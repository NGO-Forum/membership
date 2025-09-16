<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\MembershipNetwork;
use App\Models\MembershipFocalPoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use App\Exports\MembershipsExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use App\Mail\MembershipYesEmail;
use App\Mail\MembershipAdminEmail;
use App\Mail\MembershipDeclinedEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class MembershipController extends Controller
{
    public function __construct()
    {
        // Require authentication for all methods except thankyou
        $this->middleware('auth')->except(['thankyou']);
    }

    public function showForm()
    {
        $userId = Auth::id();

        // Check if user already submitted form
        $existing = Membership::where('user_id', $userId)->first();

        if ($existing) {
            return redirect()->route('membership.thankyou');
        }

        return view('membership.form');
    }

    public function submitReconfirmation(Request $request)
    {

        if (Membership::where('user_id', Auth::id())->exists()) {
            return redirect()->route('membership.thankyou');
        }

        // Validate membership answer first
        $validator = Validator::make($request->all(), [
            'membership' => 'required|in:Yes,No',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if ($request->membership === 'No') {
            // Create membership record (store only status and link to user)
            $membership = Membership::create([
                'user_id' => Auth::id(),
                'membership_status' => false, // No
                'ngo_name' => null,
                'director_name' => null,
                'director_phone' => null,
                'director_email' => null,
                'alt_name' => null,
                'alt_phone' => null,
                'alt_email' => null,
                'more_info' => null,
            ]);

            // Get user info via user_id
            $user = $membership->user;

            // Log for debugging
            Log::info('Membership declined created', [
                'name' => $user->name,
                'email' => $user->email,
                'ngo' => $user->ngo,
            ]);

            // Send email to admins
            try {
                $admins = User::where('role', 'admin')->pluck('email');
                Mail::to($admins->toArray())->send(new MembershipDeclinedEmail($user));
            } catch (\Exception $e) {
                Log::error('Failed to send "No" membership email: ' . $e->getMessage());
            }

            return redirect()->route('membership.thankyou');
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'ngo_name' => 'required_if:membership,Yes|string|max:255',
            'director_name' => 'required_if:membership,Yes|string|max:255',
            'director_phone' => 'required_if:membership,Yes|string|max:20',
            'director_email' => 'required_if:membership,Yes|email|max:255',
            'alt_name' => 'nullable|string|max:255',
            'alt_phone' => 'nullable|string|max:20',
            'alt_email' => 'nullable|email|max:255',
            'networks' => 'nullable|array',
            'networks.*' => 'in:NECCAW,BWG,RCC,NRLG,GGESI',
            'more_info' => 'required_if:membership,Yes|in:Yes,No',
            // Optional: add validation for focal points fields dynamically if needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $membership = Membership::create([
                'membership_status' => $request->membership === 'Yes',
                'ngo_name' => $request->ngo_name,
                'director_name' => $request->director_name,
                'director_phone' => $request->director_phone,
                'director_email' => $request->director_email,
                'alt_name' => $request->alt_name,
                'alt_phone' => $request->alt_phone,
                'alt_email' => $request->alt_email,
                'more_info' => $request->more_info === 'Yes',
                'user_id' => auth()->id(),
                'deadline' => now()->addDays(15),
                'status' => 'pending', // Default status
            ]);

            $membershipId = $membership->id;

            if ($request->has('networks')) {
                foreach ($request->networks as $network) {
                    $membership->networks()->create([
                        'network_name' => $network,
                    ]);

                    if ($request->filled("focal_name_{$network}")) {
                        MembershipFocalPoint::create([
                            'membership_id' => $membershipId,
                            'network_name' => $network,
                            'name' => $request->input("focal_name_{$network}"),
                            'sex' => $request->input("focal_sex_{$network}"),
                            'position' => $request->input("focal_position_{$network}"),
                            'email' => $request->input("focal_email_{$network}"),
                            'phone' => $request->input("focal_phone_{$network}"),
                        ]);
                    }
                }
            }

            DB::commit();

            $membershipConfirmed = in_array($request->membership, ['Yes', 1, '1'], true);
            $moreInfoAgreed = in_array($request->more_info, ['Yes', 1, '1'], true);
            $deadline = now()->addDays(15);
            $admins = User::where('role', 'admin')->pluck('email');

            try {
                if ($membershipConfirmed && $moreInfoAgreed) {
                    Mail::to($request->director_email)
                        ->send(new MembershipYesEmail($membership, $deadline, $admins));
                }

                if ($membershipConfirmed) {
                    Log::info('Sending admin email to: ' . implode(', ', $admins->toArray()));
                    Mail::to($admins->toArray())
                        ->send(new MembershipAdminEmail($membership));
                }
            } catch (\Exception $e) {
                Log::error('Email send failed: ' . $e->getMessage());
            }

            return redirect()->route('membership.thankyou')->with('success', 'Membership reconfirmation submitted successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Error submitting form: ' . $e->getMessage()])->withInput();
        }
    }

    public function formUpload($id)
    {
        $membership = Membership::findOrFail($id);
        return view('membership.formUpload', compact('membership'));
    }

    public function thankyou()
    {
        return view('membership.thankyou');
    }


    // Export methods
    public function exportPDF()
    {
        $memberships = Membership::with(['user', 'networks', 'focalPoints', 'applications'])->get();

        $pdf = PDF::loadView('admin.pdf', compact('memberships'))
            ->setPaper('a4', 'landscape'); // optional: landscape mode for wide tables

        return $pdf->download('memberships.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new MembershipsExport(), 'memberships.xlsx');
    }

    // Export to Word document
    public function exportWord()
    {
        $memberships = Membership::with(['networks', 'focalPoints', 'applications'])->get();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText('All Memberships', ['bold' => true, 'size' => 16, 'color' => '008000']);
        $section->addTextBreak(1);

        foreach ($memberships as $m) {
            // Membership Header
            $section->addText("Membership ID: {$m->id}", ['bold' => true, 'size' => 14, 'color' => '006400']);
            $section->addText("NGO Name: " . ($m->ngo_name ?? 'N/A'));
            $section->addText("Director: " . ($m->director_name ?? 'N/A'));
            $section->addText("Email: " . ($m->director_email ?? 'N/A'));
            $section->addText("Position (Alternate Name): " . ($m->alt_name ?? 'N/A'));
            $section->addText("Networks:");

            // Networks list
            if ($m->networks->count()) {
                $listStyle = ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED];
                foreach ($m->networks as $network) {
                    $section->addListItem($network->network_name, 0, null, $listStyle);
                }
            } else {
                $section->addText("No networks", ['italic' => true, 'color' => '808080']);
            }

            $section->addText("Created At: " . ($m->created_at?->format('d M Y') ?? 'N/A'));
            $section->addTextBreak(1);

            // Applications Section
            if ($m->applications->count()) {
                $section->addText('Applications:', ['bold' => true, 'size' => 12]);
                foreach ($m->applications as $app) {
                    $section->addText("Date: " . ($app->date?->format('d M Y') ?? 'N/A'), ['bold' => true]);
                    $section->addText("Mailing Address: " . ($app->mailing_address ?? 'N/A'));
                    $section->addText("Facebook: " . ($app->facebook ?? 'N/A'));

                    // Website as hyperlink if exists
                    if (!empty($app->website)) {
                        $section->addText('Website: ');
                        $section->addLink($app->website, $app->website, ['color' => '0000FF', 'underline' => 'single']);
                    } else {
                        $section->addText("Website: N/A");
                    }

                    // Communication Channels
                    $commChannels = (is_array($app->comm_channels) && count($app->comm_channels))
                        ? implode(', ', $app->comm_channels)
                        : 'None';
                    $section->addText("Communication Channels: " . $commChannels);

                    // Communication Phones as list
                    $section->addText("Communication Phones:");
                    if (is_array($app->comm_phones) && count($app->comm_phones)) {
                        $listStyle = ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED];
                        foreach ($app->comm_phones as $channel => $phone) {
                            $cleanPhone = preg_replace('/\D+/', '', $phone);
                            // Adding phone and clickable tel link (limited support in Word clients)
                            $section->addListItem("{$channel}: {$phone} (tel: {$cleanPhone})", 0, null, $listStyle);
                        }
                    } else {
                        $section->addText("None", ['italic' => true, 'color' => '808080']);
                    }

                    $section->addText("Vision: " . ($app->vision ?? 'N/A'));
                    $section->addText("Mission: " . ($app->mission ?? 'N/A'));
                    $section->addText("Goal: " . ($app->goal ?? 'N/A'));

                    // Files Section
                    $section->addText("Files:");
                    $fileFields = [
                        'letter' => 'Letter',
                        'constitution' => 'Constitution',
                        'activities' => 'Activities',
                        'funding' => 'Funding',
                        'registration' => 'Registration',
                        'strategic_plan' => 'Strategic Plan',
                        'fundraising_strategy' => 'Fundraising Strategy',
                        'audit_report' => 'Audit Report',
                        'signature' => 'Signature',
                    ];
                    $hasFiles = false;
                    foreach ($fileFields as $field => $label) {
                        if (!empty($app->$field)) {
                            $fileUrl = asset('storage/' . $app->$field);
                            $section->addLink($fileUrl, $label, ['color' => '0000FF', 'underline' => 'single']);
                            $hasFiles = true;
                        }
                    }
                    if (!$hasFiles) {
                        $section->addText('No files available', ['italic' => true, 'color' => '808080']);
                    }

                    $section->addTextBreak(1);
                }
            } else {
                $section->addText('No applications', ['italic' => true, 'color' => '808080']);
                $section->addTextBreak(1);
            }

            // Separator line between memberships
            $section->addLine(['weight' => 1, 'width' => 600, 'height' => 0]);
            $section->addTextBreak(1);
        }

        // Save and return response
        $fileName = 'memberships.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }


    public function edit($id)
    {
        $membership = Membership::findOrFail($id);

        return view('admin.editMembership', compact('membership'));
    }


    public function update(Request $request, $id)
    {
        $membership = Membership::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'ngo_name' => 'required|string|max:255',
            'director_name' => 'required|string|max:255',
            'director_phone' => 'required|string|max:20',
            'director_email' => 'required|email|max:255',
            'alt_name' => 'nullable|string|max:255',
            'alt_phone' => 'nullable|string|max:20',
            'alt_email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $membership->update([
                'ngo_name' => $request->ngo_name,
                'director_name' => $request->director_name,
                'director_phone' => $request->director_phone,
                'director_email' => $request->director_email,
                'alt_name' => $request->alt_name,
                'alt_phone' => $request->alt_phone,
                'alt_email' => $request->alt_email,
            ]);

            return redirect()->route('admin.membership')->with('success', 'Membership updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);

        DB::beginTransaction();
        try {
            // Delete related networks and focal points
            $membership->networks()->delete();
            $membership->focalPoints()->delete();

            $membership->delete();

            DB::commit();
            return redirect()->route('membership.showForm')->with('success', 'Membership deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
