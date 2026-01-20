<?php

namespace App\Http\Controllers;

use App\Models\MembershipUpload;
use App\Models\NewMembership;
use App\Models\AssessmentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMembershipUploadedMail;

class MembershipUploadController extends Controller
{
    public function form()
    {
        return view('membership.membershipUpload');
    }

    public function store(Request $request)
    {
        /* =====================================================
         | 1. VALIDATION
         ===================================================== */
        $validatedUpload = $request->validate([
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

        $validatedAssessment = $request->validate([
            'ngo_type'         => 'required|in:Local Organization,International Organization',
            'established_date' => 'nullable|date',
            'vision'           => 'nullable|string',
            'mission'          => 'nullable|string',
            'address'          => 'nullable|string',
            'key_actions'      => 'nullable|string',
            'membership_fee'   => 'nullable|numeric|min:0',
        ]);

        /* =====================================================
         | 2. GET USER MEMBERSHIP (SAFE)
         ===================================================== */
        $newMembership = NewMembership::where('user_id', auth()->id())
            ->latest()
            ->firstOrFail();

        /* =====================================================
         | 3. FILE UPLOADS
         ===================================================== */
        $uploadFields = [
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
        ];

        foreach ($uploadFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $ext  = $file->getClientOriginalExtension();

                $filename = $name . '_' . time() . '.' . $ext;
                $validatedUpload[$field] = $file->storeAs(
                    'memberships',
                    $filename,
                    'public'
                );
            }
        }

        /* =====================================================
         | 4. SIGNATURE
         ===================================================== */
        if ($request->filled('signature')) {
            $image = str_replace(
                ['data:image/png;base64,', ' '],
                ['', '+'],
                $request->signature
            );

            $path = 'memberships/signatures/signature_' . time() . '.png';
            Storage::disk('public')->put($path, base64_decode($image));

            $validatedUpload['signature'] = $path;
        }

        /* =====================================================
         | 5. SAVE MEMBERSHIP UPLOAD
         ===================================================== */
        $membershipUpload = MembershipUpload::create(
            array_merge($validatedUpload, [
                'new_membership_id' => $newMembership->id,
            ])
        );

        /* =====================================================
         | 6. NETWORKS + FOCAL POINTS
         ===================================================== */
        if ($request->has('networks')) {
            foreach ($request->networks as $network) {
                $membershipUpload->networks()->create([
                    'network_name' => $network,
                ]);

                $membershipUpload->focalPoints()->create([
                    'network_name' => $network,
                    'name'         => $request->input("focal_name_$network"),
                    'sex'          => $request->input("focal_sex_$network"),
                    'position'     => $request->input("focal_position_$network"),
                    'email'        => $request->input("focal_email_$network"),
                    'phone'        => $request->input("focal_phone_$network"),
                    'summaries'    => $request->input("focal_summaries_$network"),
                ]);
            }
        }

        /* =====================================================
        | 7. CREATE ASSESSMENT REPORT
        ===================================================== */
        if (!$newMembership->assessmentReport) {

            // Convert key_actions string → JSON array
            $keyActions = null;

            if (!empty($validatedAssessment['key_actions'])) {
                $keyActions = array_values(array_filter(
                    preg_split("/\r\n|\n|\r/", $validatedAssessment['key_actions'])
                ));
            }

            AssessmentReport::create([
                'new_membership_id' => $newMembership->id,
                'ngo_type'          => $validatedAssessment['ngo_type'],
                'established_date'  => $validatedAssessment['established_date'] ?? null,
                'vision'            => $validatedAssessment['vision'] ?? null,
                'mission'           => $validatedAssessment['mission'] ?? null,
                'address'           => $validatedAssessment['address'] ?? null,
                'key_actions'       => $keyActions, // ✅ ARRAY → JSON
                'membership_fee'    => $validatedAssessment['membership_fee'] ?? null,
            ]);
        }

        $admin = \App\Models\User::where('role', 'admin')->first();

        if ($admin && $admin->email) {
            Mail::to($admin->email)
                ->send(new NewMembershipUploadedMail($newMembership));
        }

        return redirect()->route('membership.thankyou');
    }
}
