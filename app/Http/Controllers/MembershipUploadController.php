<?php

namespace App\Http\Controllers;

use App\Models\MembershipUpload;
use App\Models\NewMembership;
use App\Models\BasicOrganizationalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMembershipUploadedMail;
use App\Mail\NewMembershipMail;
use App\Models\Ngo;
use App\Models\User;

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
            'board' => 'nullable|file|mimes:pdf,doc,docx',
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

            // Location (from your dropdowns)
            'province' => 'nullable|integer|min:0',
            'district' => 'nullable|integer|min:0',
            'commune'  => 'nullable|integer|min:0',
            'village'  => 'nullable|integer|min:0',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,webp,zip,rar,txt|max:10240',

            // key_actions comes as textarea string (line by line)
            'key_actions'      => 'nullable|string',

            // these if you send multi-select arrays
            'key_program_focuses' => 'nullable|array',
            'target_groups'       => 'nullable|array',
            'ministries_partners'      => 'nullable|string',
            'development_partners'     => 'nullable|string',
            'private_sector_partners'  => 'nullable|string',


            // staff/budget/fees
            'staff_total'     => 'nullable|integer|min:0',
            'staff_female'    => 'nullable|integer|min:0',
            'staff_pwd'       => 'nullable|integer|min:0',
            'budget_year'     => 'nullable|digits:4',
            'annual_budget'   => 'nullable|numeric|min:0',
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
            'board',
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

        $assessmentFilePath = null;

        if ($request->hasFile('file')) {
            $assessmentFilePath = $request->file('file')->store('basic_infos', 'public');
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
        if (!$newMembership->basicInformation) {

            // Convert key_actions string → JSON array
            $keyActions = null;

            if (!empty($validatedAssessment['key_actions'])) {
                $keyActions = array_values(array_filter(
                    preg_split("/\r\n|\n|\r/", $validatedAssessment['key_actions'])
                ));
            }

            $toArray = function ($value) {
                if (empty($value)) return null;

                return array_values(array_filter(array_map(
                    'trim',
                    preg_split("/\r\n|\n|\r/", $value)
                )));
            };

            $ministriesPartners = $toArray($validatedAssessment['ministries_partners'] ?? null);
            $developmentPartners = $toArray($validatedAssessment['development_partners'] ?? null);
            $privateSectorPartners = $toArray($validatedAssessment['private_sector_partners'] ?? null);

            $annualBudget = $validatedAssessment['annual_budget'] ?? null;
            $membershipType = $newMembership->membership_type;

            // if full member, annual_budget must exist
            if ($membershipType === 'Full member' && ($annualBudget === null || $annualBudget === '')) {
                return back()
                    ->withErrors(['annual_budget' => 'Annual budget is required for Full member.'])
                    ->withInput();
            }

            $membershipFee = null;

            if ($membershipType === 'Associate member') {
                $membershipFee = 100;
            } else {
                $annualBudget = (float) $annualBudget;

                if ($annualBudget <= 100000) {
                    $membershipFee = 10;
                } elseif ($annualBudget <= 200000) {
                    $membershipFee = 50;
                } elseif ($annualBudget <= 400000) {
                    $membershipFee = 100;
                } elseif ($annualBudget <= 800000) {
                    $membershipFee = 200;
                } else {
                    $membershipFee = 300;
                }
            }

            BasicOrganizationalInformation::firstOrCreate(
                ['new_membership_id' => $newMembership->id],
                [
                    'ngo_type' => $validatedAssessment['ngo_type'],

                    'established_date' => $validatedAssessment['established_date'] ?? null,
                    'vision' => $validatedAssessment['vision'] ?? null,
                    'mission' => $validatedAssessment['mission'] ?? null,

                    'key_actions' => $keyActions,
                    'key_program_focuses' => $validatedAssessment['key_program_focuses'] ?? null,
                    'target_groups' => $validatedAssessment['target_groups'] ?? null,

                    'staff_total' => $validatedAssessment['staff_total'] ?? null,
                    'staff_female' => $validatedAssessment['staff_female'] ?? null,
                    'staff_pwd' => $validatedAssessment['staff_pwd'] ?? null,

                    'budget_year' => $validatedAssessment['budget_year'] ?? null,
                    'annual_budget' => $validatedAssessment['annual_budget'] ?? null,

                    // Location fields
                    'province' => $validatedAssessment['province'] ?? null,
                    'district' => $validatedAssessment['district'] ?? null,
                    'commune'  => $validatedAssessment['commune'] ?? null,
                    'village'  => $validatedAssessment['village'] ?? null,
                    'file' => $assessmentFilePath,

                    'membership_fee' => $membershipFee,

                    'ministries_partners'     => $ministriesPartners,
                    'development_partners'    => $developmentPartners,
                    'private_sector_partners' => $privateSectorPartners,

                ]
            );
        }

        try {
            $admin = User::where('role', 'admin')->first();

            // ✅ Detect old membership (reconfirm) by org name / abbreviation
            $orgName = strtolower(trim($newMembership->org_name_en ?? ''));
            $abbr    = strtolower(trim($newMembership->org_name_abbreviation ?? ''));

            $isExistingNgo = Ngo::query()
                ->when($orgName !== '', fn($q) => $q->orWhereRaw('LOWER(name) = ?', [$orgName]))
                ->when($abbr !== '', fn($q) => $q->orWhereRaw('LOWER(abbreviation) = ?', [$abbr]))
                ->exists();

            // ✅ Send to admin (admin gets your admin template)
            if (!empty($admin?->email)) {
                Mail::to($admin->email)
                    ->send(new NewMembershipUploadedMail($newMembership));
            }

            // ✅ Send to director (same template but auto text changes)
            if (!empty($newMembership->director_email)) {
                Mail::to($newMembership->director_email)
                    ->send(new NewMembershipMail($newMembership, $isExistingNgo));
            }
        } catch (\Throwable $e) {
            Log::error('Membership email error: ' . $e->getMessage(), [
                'new_membership_id' => $newMembership->id ?? null,
                'director_email' => $newMembership->director_email ?? null,
            ]);
        }

        return redirect()->route('membership.thankyou');
    }
}
