<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\NewMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class AdminController extends Controller
{
    public function __construct()
    {
        // Ensure only admin can access these methods
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }
            abort(403, 'Unauthorized access.');
        });
    }

    public function index()
    {
        $totalApproved = NewMembership::where('status', 'approved')->count();
        $totalPending  = NewMembership::where('status', 'pending')->count();
        $totalCancel   = NewMembership::where('status', 'rejected')->count();
        $totalEvents   = DB::table('events')->count();

        $members = NewMembership::with('basicInformation')->get();

        $mapPoints = [];
        $provinceGroups = []; // ✅ for province click chart popup

        foreach ($members as $m) {
            $b = $m->basicInformation;
            if (!$b) continue;

            // Extract location from uploaded TXT/CSV file
            [$province, $district, $commune, $village, $locationText] =
                $this->extractLocationFromTextFile($b->file);

            /* =====================================================
             | ✅ PROVINCE GROUPING FOR "CHART" POPUP
             ===================================================== */
            if (!empty($province)) {
                $provinceKey = trim($province);
                $ngoName = $m->org_name_en ?? 'N/A';

                if (!isset($provinceGroups[$provinceKey])) {
                    $provinceGroups[$provinceKey] = [
                        'total' => 0,
                        'ngos'  => []
                    ];
                }

                $provinceGroups[$provinceKey]['total']++;

                if (!isset($provinceGroups[$provinceKey]['ngos'][$ngoName])) {
                    $provinceGroups[$provinceKey]['ngos'][$ngoName] = [
                        'count' => 0,
                        'url'   => route('admin.newShowMembership', $m->id),
                        'loc'   => $locationText ?? '',
                    ];
                }

                $provinceGroups[$provinceKey]['ngos'][$ngoName]['count']++;

                // keep latest location text (optional)
                if (!empty($locationText)) {
                    $provinceGroups[$provinceKey]['ngos'][$ngoName]['loc'] = $locationText;
                }
            }

            /* =====================================================
             | ✅ GEO-CODE (cache lat/lng) IF MISSING
             ===================================================== */
            if ((empty($b->latitude) || empty($b->longitude)) && !empty($locationText)) {
                $coords = $this->geocode($locationText);
                if ($coords) {
                    $b->latitude  = $coords['lat'];
                    $b->longitude = $coords['lng'];
                    $b->save();
                }
            }

            // still missing coords? skip pin
            if (empty($b->latitude) || empty($b->longitude)) continue;

            $fileUrl = $b->file ? asset('storage/' . $b->file) : null;

            $mapPoints[] = [
                'id'        => $m->id,
                'org'       => $m->org_name_en ?? 'N/A',
                'director'  => $m->director_name ?? 'N/A',
                'status'    => $m->status ?? 'N/A',
                'lat'       => (float) $b->latitude,
                'lng'       => (float) $b->longitude,
                'location'  => $locationText ?: 'N/A',
                'fileUrl'   => $fileUrl,
                'detailUrl' => route('admin.newShowMembership', $m->id),
            ];
        }

        return view('admin.dashboard', compact(
            'totalApproved',
            'totalPending',
            'totalCancel',
            'totalEvents',
            'mapPoints',
            'provinceGroups'
        ));
    }


    private function extractLocationFromTextFile(?string $path): array
    {
        if (!$path || !Storage::disk('public')->exists($path)) {
            return [null, null, null, null, null];
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($ext, ['txt', 'csv'])) {
            return [null, null, null, null, null];
        }

        try {
            $content = trim(Storage::disk('public')->get($path));
        } catch (\Throwable $e) {
            Log::warning('Cannot read location file', ['path' => $path, 'error' => $e->getMessage()]);
            return [null, null, null, null, null];
        }

        // Normalize
        $content = trim(preg_replace('/\s+/', ' ', $content));
        $content = rtrim($content, ".");

        // Label format: Province: Phnom Penh
        $get = function (string $label) use ($content): ?string {
            if (preg_match('/' . preg_quote($label, '/') . '\s*:\s*(.+)/i', $content, $m)) {
                return trim($m[1]);
            }
            return null;
        };

        $province = $get('Province');
        $district = $get('District');
        $commune  = $get('Commune');
        $village  = $get('Village');

        // If label format exists
        if ($province || $district || $commune || $village) {
            $locationText = trim(implode(', ', array_filter([
                $village,
                $commune,
                $district,
                $province,
                'Cambodia'
            ])));
            return [$province, $district, $commune, $village, $locationText ?: null];
        }

        // Comma format (also supports your example sentence)
        if (strpos($content, ',') !== false) {
            $parts = array_map('trim', explode(',', $content));

            $clean = function (?string $s): ?string {
                if (!$s) return null;
                $s = preg_replace('/\((.*?)\)/', '', $s); // remove (Sangkat), (Khan)
                $s = preg_replace('/\bVillage\b/i', '', $s);
                $s = preg_replace('/\bCommune\b/i', '', $s);
                $s = preg_replace('/\bDistrict\b/i', '', $s);
                $s = preg_replace('/\bProvince\b/i', '', $s);
                return trim($s) ?: null;
            };

            $village  = $clean($parts[0] ?? null);
            $commune  = $clean($parts[1] ?? null);
            $district = $clean($parts[2] ?? null);
            $province = $clean($parts[3] ?? null);

            $locationText = trim(implode(', ', array_filter([
                $village,
                $commune,
                $district,
                $province,
                'Cambodia'
            ])));

            return [$province, $district, $commune, $village, $locationText ?: null];
        }

        return [null, null, null, null, null];
    }

    /**
     * Geocode using OpenStreetMap Nominatim.
     */
    private function geocode(string $query): ?array
    {
        try {
            $client = new Client([
                'timeout' => 15,
                'headers' => [
                    'User-Agent' => 'NGOF Membership System',
                ],
            ]);

            $res = $client->get('https://nominatim.openstreetmap.org/search', [
                'query' => [
                    'q' => $query,
                    'format' => 'json',
                    'limit' => 1,
                ],
            ]);

            $data = json_decode($res->getBody()->getContents(), true);
            if (empty($data)) return null;

            return [
                'lat' => (float) $data[0]['lat'],
                'lng' => (float) $data[0]['lon'],
            ];
        } catch (\Throwable $e) {
            Log::warning('Geocode failed', ['query' => $query, 'error' => $e->getMessage()]);
            return null;
        }
    }


    // membership
    public function newMembership()
    {
        $newMemberships = NewMembership::with([
            'user',
            'membershipUploads.networks',
            'membershipUploads.focalPoints',
            'assessmentReport',
        ])->where('status', 'approved')->get();

        return view('admin.newMembership', compact('newMemberships'));
    }

    public function newShowMembership($id)
    {
        $membership = NewMembership::with([
            'user',
            'membershipUploads.networks',
            'membershipUploads.focalPoints',
            'basicInformation',
            'registrations.event'
        ])
            ->where('id', $id)
            ->firstOrFail();
        return view('admin.newShowMembership', compact('membership'));
    }
}
