<?php

namespace App\Http\Controllers;

use App\Models\MembershipUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\IOFactory;
use GuzzleHttp\Client;

use App\Models\NewMembership;

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

        // Upload files
        foreach (
            [
                'letter',
                'mission_vision',
                'constitution',
                'activities',
                'funding',
                'authorization',
                'strategic_plan',
                'fundraising_strategy',
                'audit_report',
                'logo'
            ] as $field
        ) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('memberships', 'public');
            }
        }


        if ($request->filled('signature')) {
            $data = $request->input('signature');

            // Remove the base64 prefix like "data:image/png;base64,"
            $image = str_replace('data:image/png;base64,', '', $data);
            $image = str_replace(' ', '+', $image);

            // Decode the base64 string
            $imageData = base64_decode($image);

            // Create unique file name
            $fileName = 'signature_' . time() . '.png';
            $filePath = 'memberships/signatures/' . $fileName;

            // Save to storage/app/public/memberships/signatures
            Storage::disk('public')->put($filePath, $imageData);

            // Store file path in DB instead of raw base64
            $validated['signature'] = $filePath;
        }

        // Save membership
        $latestMembership = NewMembership::latest()->first();
        $membership = MembershipUpload::create(array_merge($validated, [
            'new_membership_id' => $latestMembership->id ?? null, // fallback if none
        ]));

        // Save networks + focal points
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

        // ✅ Send file paths to n8n webhook
        try {
            $n8nWebhookUrl = 'https://automate.mengseu-student.site/webhook/membership-upload';

            $multipart = [
                [
                    'name' => 'membership_id',
                    'contents' => (string)$membership->id,
                ],
            ];

            $fileFields = [
                'letter',
                'mission_vision',
                'constitution',
                'activities',
                'funding',
                'authorization',
                'strategic_plan',
                'fundraising_strategy',
                'audit_report',
            ];

            foreach ($fileFields as $field) {
                if ($membership->$field) {
                    $filePath = storage_path("app/public/{$membership->$field}");
                    if (file_exists($filePath)) {
                        $multipart[] = [
                            'name' => "binary[$field]",
                            'contents' => fopen($filePath, 'r'),
                            'filename' => basename($filePath),
                        ];
                    }
                }
            }

            Log::info('📦 Prepared multipart fields for n8n:', collect($multipart)->pluck('name')->toArray());

            $client = new \GuzzleHttp\Client([
                'timeout' => 300,
                'verify' => false, // optional if you’re using self-signed SSL
            ]);

            $response = $client->post($n8nWebhookUrl, [
                'headers' => ['Accept' => 'application/json'],
                'multipart' => $multipart,
            ]);

            $body = $response->getBody()->getContents();

            Log::info("✅ Files sent to n8n successfully.", [
                'status' => $response->getStatusCode(),
                'response' => $body,
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Failed to send to n8n: ' . $e->getMessage());
        }



        return redirect()->route('membership.thankyou');
    }
}
