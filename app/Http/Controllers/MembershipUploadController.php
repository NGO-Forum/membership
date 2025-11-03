<?php

namespace App\Http\Controllers;

use App\Models\MembershipUpload;
use App\Models\NewMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class MembershipUploadController extends Controller
{
    public function form()
    {
        return view('membership.membershipUpload');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'networks' => 'nullable|array',
            'pledge_accept' => 'required',
            'letter' => 'nullable|file|mimes:pdf,doc,docx',
            'mission_vision' => 'nullable|file|mimes:pdf,doc,docx',
            'constitution' => 'nullable|file|mimes:pdf,doc,docx',
            'activities' => 'nullable|file|mimes:pdf,doc,docx',
            'funding' => 'nullable|file|mimes:pdf,doc,docx',
            'authorization' => 'nullable|file|mimes:pdf,doc,docx',
            'strategic_plan' => 'nullable|file|mimes:pdf,doc,docx',
            'fundraising_strategy' => 'nullable|file|mimes:pdf,doc,docx',
            'audit_report' => 'nullable|file|mimes:pdf,doc,docx',
            'logo' => 'required|mimes:jpeg,png,jpg,gif,svg,webp,pdf|max:2048',
            'signature' => 'nullable|string',
        ]);

        // ✅ Preserve readable filenames when saving
        $uploadFields = [
            'letter', 'mission_vision', 'constitution', 'activities', 'funding',
            'authorization', 'strategic_plan', 'fundraising_strategy', 'audit_report', 'logo'
        ];

        foreach ($uploadFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();

                // Unique readable name like: Registration_Letter_1730652000.pdf
                $storedName = $originalName . '_' . time() . '.' . $extension;

                // Save file
                $path = $file->storeAs('memberships', $storedName, 'public');
                $validated[$field] = $path;
            }
        }

        // ✅ Save signature (base64 image)
        if ($request->filled('signature')) {
            $image = str_replace('data:image/png;base64,', '', $request->input('signature'));
            $image = str_replace(' ', '+', $image);
            $imageData = base64_decode($image);
            $fileName = 'signature_' . time() . '.png';
            $filePath = 'memberships/signatures/' . $fileName;
            Storage::disk('public')->put($filePath, $imageData);
            $validated['signature'] = $filePath;
        }

        // ✅ Save membership record
        $latestMembership = NewMembership::latest()->first();
        $membership = MembershipUpload::create(array_merge($validated, [
            'new_membership_id' => $latestMembership->id ?? null,
        ]));

        // ✅ Save networks + focal points
        if ($request->has('networks')) {
            foreach ($request->networks as $network) {
                $membership->networks()->create(['network_name' => $network]);
                $membership->focalPoints()->create([
                    'network_name' => $network,
                    'name' => $request->input("focal_name_$network"),
                    'sex' => $request->input("focal_sex_$network"),
                    'position' => $request->input("focal_position_$network"),
                    'email' => $request->input("focal_email_$network"),
                    'phone' => $request->input("focal_phone_$network"),
                ]);
            }
        }

        // ✅ Send uploaded files to n8n for OCR/Processing
        try {
            $n8nWebhookUrl = 'https://automate.mengseu-student.site/webhook/membership-upload';
            $multipart = [
                [
                    'name' => 'membership_id',
                    'contents' => (string) $membership->id,
                ],
            ];

            // Attach readable files
            foreach ($uploadFields as $field) {
                if (!empty($membership->$field)) {
                    $filePath = storage_path("app/public/{$membership->$field}");
                    if (file_exists($filePath)) {
                        $originalName = basename($filePath);
                        $multipart[] = [
                            'name'     => "binary.$field",
                            'contents' => fopen($filePath, 'r'),
                            'filename' => $originalName,
                        ];
                        Log::info("📎 Attached file: {$originalName}");
                    } else {
                        Log::warning("⚠️ File missing: {$filePath}");
                    }
                }
            }

            Log::info("📤 Sending to n8n webhook {$n8nWebhookUrl}");
            Log::info('🧾 Fields: ' . json_encode(collect($multipart)->pluck('name')));

            $client = new Client(['timeout' => 300, 'verify' => false]);
            $response = $client->post($n8nWebhookUrl, ['multipart' => $multipart]);

            Log::info('✅ Files sent to n8n successfully', [
                'status' => $response->getStatusCode(),
                'body'   => (string) $response->getBody(),
            ]);

        } catch (\Throwable $e) {
            Log::error('❌ n8n upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return redirect()->route('membership.thankyou');
    }
}
