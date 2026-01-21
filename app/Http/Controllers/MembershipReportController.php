<?php

namespace App\Http\Controllers;

use App\Models\NewMembership;
use App\Models\AssessmentReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportApprovalMail;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class MembershipReportController extends Controller
{
    public function index()
    {
        $newMemberships = NewMembership::where('status', 'approved')->get();
        return view('reports.membership', compact('newMemberships'));
    }

    public function report(NewMembership $membership)
    {
        abort_unless(
            in_array(auth()->user()->role, ['manager', 'ed', 'board']),
            403
        );

        $report = AssessmentReport::firstOrCreate(
            ['new_membership_id' => $membership->id],
            ['status' => 'draft']
        );

        return view('reports.index', [
            'membership' => $membership,
            'report' => $report,

            'manager' => User::where('role', 'manager')->first(),
            'ed' => User::where('role', 'ed')->first(),
            'board' => User::where('role', 'board')->first(),

            // permissions
            'canEdit' => in_array(auth()->user()->role, ['manager', 'ed']),
            'canApproveManager' => auth()->user()->role === 'manager' && $report->status === 'draft',
            'canApproveED' => auth()->user()->role === 'ed' && $report->status === 'manager_approved',
            'canApproveBoard' => auth()->user()->role === 'board' && $report->status === 'ed_approved',

            // TEXT ONLY (strip HTML)
            'summary_text' => strip_tags($report->summary_html['html'] ?? ''),
            'conclusion_text' => strip_tags($report->conclusion_html['html'] ?? ''),
        ]);
    }


    public function update(Request $request, AssessmentReport $report)
    {
        abort_unless(
            in_array(auth()->user()->role, ['manager', 'ed']),
            403
        );

        $request->validate([
            'summary_html' => 'nullable|string',
            'conclusion_html' => 'nullable|string',
        ]);

        if ($request->summary_html) {
            $report->summary_html = ['html' => $request->summary_html];
        }

        if ($request->conclusion_html) {
            $report->conclusion_html = ['html' => $request->conclusion_html];
        }

        $report->save();

        return back()->with('success', 'Report updated');
    }



    public function show(NewMembership $membership)
    {
        $report = AssessmentReport::firstOrCreate(
            ['new_membership_id' => $membership->id],
            ['status' => 'draft']
        );

        return view('reports.show', [
            'membership' => $membership,
            'report'     => $report,
            'manager'    => User::where('role', 'manager')->first(),
            'ed'         => User::where('role', 'ed')->first(),
            'board'      => User::where('role', 'board')->first(),
        ]);
    }

    /* =====================================================
     | ADMIN – GENERATE AI REPORT (ONLY ONCE)
     ===================================================== */
    public function generate(NewMembership $membership)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $report = AssessmentReport::updateOrCreate(
            ['new_membership_id' => $membership->id],
            ['status' => 'draft']
        );

        /* ===== SUMMARY ===== */
        $summaryResponse = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $this->summaryPrompt($membership, $report),
                ]
            ],
        ]);

        $summary = $summaryResponse->choices[0]->message->content ?? '';

        /* ===== CONCLUSION ===== */
        $conclusionResponse = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $this->conclusionPrompt(),
                ]
            ],
        ]);

        $conclusion = $conclusionResponse->choices[0]->message->content ?? '';

        /* ===== CHECKLIST ===== */
        $checklist = $this->buildChecklist($membership);

        // IMPORTANT: save STRINGS unless columns are JSON
        $report->update([
            'summary_html'    => $summary,
            'checklist_json'  => $checklist,
            'conclusion_html' => $conclusion,
        ]);

        $this->notifyRole('manager', $report);

        return back()->with('success', 'Assessment report generated successfully.');
    }


    /* ================= APPROVALS ================= */
    public function approveManager(Request $request, AssessmentReport $report)
    {
        abort_unless(auth()->user()->role === 'manager', 403);
        if ($report->status !== 'draft') abort(403);

        // $this->saveSignature($request);

        $report->update([
            'status' => 'manager_approved',
            'manager_approved_at' => now()
        ]);

        // $this->notifyRole('ed', $report);
        // ✅ ALSO approve the membership
        $membership = $report->membership; // relationship
        $membership->update([
            'status' => 'approved'
        ]);

        return redirect()->route('reports.show', [
            'membership' => $report->new_membership_id
        ]);
    }

    // public function approveED(Request $request, AssessmentReport $report)
    // {
    //     abort_unless(auth()->user()->role === 'ed', 403);
    //     if ($report->status !== 'manager_approved') abort(403);

    //     $this->saveSignature($request);

    //     $report->update([
    //         'status' => 'ed_approved',
    //         'ed_approved_at' => now()
    //     ]);

    //     $this->notifyRole('board', $report);

    //     return redirect()->route('reports.thankyou');
    // }

    // public function approveBoard(Request $request, AssessmentReport $report)
    // {
    //     abort_unless(auth()->user()->role === 'board', 403);
    //     if ($report->status !== 'ed_approved') abort(403);

    //     $this->saveSignature($request);

    //     $report->update([
    //         'status' => 'board_approved',
    //         'board_approved_at' => now()
    //     ]);

    //     $this->notifyRole('operations', $report);

    //     return redirect()->route('reports.thankyou');
    // }

    // private function saveSignature(Request $request)
    // {
    //     $request->validate([
    //         'signature' => 'required|image|max:2048'
    //     ]);

    //     $path = $request->file('signature')->store('signatures', 'public');

    //     $user = User::find(auth()->id());
    //     $user->signature = $path;
    //     $user->save();
    // }

    private function notifyRole(string $role, AssessmentReport $report)
    {
        $user = User::where('role', $role)->first();

        if ($user && $user->email) {
            Mail::to($user->email)
                ->send(new ReportApprovalMail($report, $role));
        }
    }

    public function export(NewMembership $membership)
    {
        abort_unless(
            in_array(auth()->user()->role, ['manager', 'ed', 'board', 'admin']),
            403
        );

        $report = $membership->assessmentReport;

        $manager = \App\Models\User::where('role', 'manager')->first();
        $ed      = \App\Models\User::where('role', 'ed')->first();
        $board   = \App\Models\User::where('role', 'board')->first();

        $pdf = Pdf::loadView('reports.export', [
            'membership' => $membership,
            'report'     => $report,
            'manager'    => $manager,
            'ed'         => $ed,
            'board'      => $board,
        ])
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => true,
            ]);

        return $pdf->download(
            'Assessment_Report_' . $membership->org_name_en . '.pdf'
        );
    }


    private function summaryPrompt($membership, $report)
    {
        return "
            Write Section 1 of an official NGO Forum membership assessment report as HTML ONLY.

            STRICT RULES:
            - Output ONLY valid HTML
            - Use ONLY <p> tags (NO headings inside)
            - Past tense
            - Formal NGO assessment language
            - No markdown
            - No code fences
            - Write in continuous narrative paragraphs suitable for Board review

            CONTENT REQUIREMENTS:
            Paragraph 1:
            Provide an overview of the NGO applicant including its name, type, year of establishment, location, mission, vision, main focus areas, and notable achievements.

            Paragraph 2:
            Assess the completeness of submitted documents, clearly noting any missing but non-compulsory items without weakening the overall assessment.

            Paragraph 3:
            Evaluate the organization’s overall suitability for NGO Forum membership and clearly state the assessment conclusion.

            DATA:
            Organization: {$membership->org_name_en}
            Type: {$membership->assessmentReport->ngo_type}
            Location: {$membership->assessmentReport->address}
            Mission: {$membership->assessmentReport->mission}
            Vision: {$membership->assessmentReport->vision}
            ";
    }


    private function conclusionPrompt()
    {
        return "
            Write Section 3 as HTML ONLY for an official NGO Forum membership assessment report intended for review by Senior Management, Executive Director, and Board of Directors.

            CRITICAL RULES:
            - Output ONLY valid HTML
            - DO NOT include plain text outside HTML tags
            - DO NOT repeat content
            - Use ONLY these tags: <h3>, <h4>, <p>, <ul>, <li>, <strong>
            - Write in formal NGO governance and assessment language
            - Use past tense throughout
            - Do NOT invent facts or documents
            - Provide sufficient detail suitable for Board-level decision making
            - Maintain a professional, neutral, and evidence-based tone
            - DO NOT wrap the output in ``` or ```html
            - Output raw HTML only

            STRUCTURE (FOLLOW EXACTLY):

            <p>
            A detailed paragraph summarizing the overall evaluation of the organization’s membership application.
            The paragraph should confirm the organization’s demonstrated commitment to its mission and vision,
            its alignment with inclusive and sustainable development principles, and its relevance to the mandate
            and strategic objectives of NGO Forum on Cambodia. The tone should reflect a formal assessment
            conducted for senior leadership and Board review.
            </p>

            <p>
            A sentence introducing the recommended strategic directions aimed at strengthening the organization’s
            effectiveness, sustainability, and contribution to the NGO Forum network.
            </p>

            <ul>
            <li><strong>Cross-Cutting Programs:</strong> Provide a clear explanation of how integrated programming approaches enhance impact and address multiple development challenges simultaneously.</li>
            <li><strong>Social Enterprises:</strong> Explain the role of social enterprises in supporting financial sustainability while advancing social objectives.</li>
            <li><strong>Monitoring Strategies:</strong> Describe the importance of robust monitoring and evaluation systems for accountability, learning, and evidence-based decision-making.</li>
            <li><strong>Organizational Capacity Building:</strong> Elaborate on the need to strengthen human resources, systems, and institutional capacity to ensure effective program implementation.</li>
            <li><strong>Partnerships:</strong> Highlight the value of strategic partnerships and collaboration within the NGO Forum network and with external stakeholders.</li>
            <li><strong>Awareness and Advocacy Campaigns:</strong> Explain how advocacy and public awareness initiatives support policy influence and community engagement.</li>
            </ul>

            <p>
            A paragraph explaining how the implementation of these recommended strategies is expected to
            strengthen organizational impact, improve sustainability, and enhance the organization’s contribution
            to collective civil society efforts in Cambodia.
            </p>

            <h4>Key Strengths of the Application:</h4>

            <ul>
            <li><strong>Clear Mission and Vision:</strong> Describe how the organization’s mission and vision provide strategic clarity and alignment with NGO Forum values.</li>
            <li><strong>Comprehensive Documentation:</strong> Explain how the submitted documentation demonstrates transparency, preparedness, and compliance with membership requirements.</li>
            <li><strong>Strong Organizational Structure:</strong> Assess the governance and management arrangements that support accountability and effective decision-making.</li>
            <li><strong>Financial Accountability:</strong> Comment on financial management practices and the importance of accountability and transparency.</li>
            <li><strong>Active Participation:</strong> Describe the organization’s demonstrated or intended engagement in networks, collaboration, and collective action.</li>
            </ul>

            <p>
            <strong>Minor Gap Identified:</strong>
            Provide a factual description of any missing or incomplete documentation. Clearly state that such gaps
            are not compulsory requirements and do not undermine the overall strength of the application, but
            should be addressed to further strengthen organizational readiness.
            </p>

            <h4>Recommendation:</h4>
            <p>
            State clearly whether the membership should be approved or approved with conditions. If conditions
            apply, specify them clearly and concisely, ensuring that the recommendation is suitable for formal
            Board endorsement.
            </p>

            <h4>Conclusion:</h4>
            <p>
            Provide a final concluding paragraph affirming the organization’s suitability for membership in NGO
            Forum on Cambodia and outlining the anticipated positive contribution to the Forum’s mission, networks,
            and collective advocacy efforts.
            </p>

            FINAL DECISION RULE:
            If minor gaps exist, the recommendation MUST be approval with conditions.
        ";
    }


    private function buildChecklist($membership)
    {
        $upload = $membership->membershipUploads()->latest()->first();
        $templates = $this->checklistTemplates();

        $orgName = $membership->org_name_en ?? 'The organization';

        $results = [];

        foreach ($templates as $field => $template) {

            $hasFile = $upload && !empty($upload->$field);

            $commentTemplate = $hasFile
                ? $template['yes']
                : $template['no'];

            $results[] = [
                'field'   => $field,
                'label'   => ucwords(str_replace('_', ' ', $field)),
                'rating'  => $hasFile ? 5 : 3,
                'comment' => str_replace('{ORG}', $orgName, $commentTemplate),
                'file_url' => $hasFile ? Storage::url($upload->$field) : null,
            ];
        }

        return $results;
    }


    private function checklistTemplates()
    {
        return [
            'letter' => [
                'yes' => '{ORG} included a formal letter of intent explaining their motivation and commitment to join the NGO Forum, which demonstrates a clear understanding of the purpose and objectives of the network.',
                'no'  => '{ORG} did not submit a formal letter of intent outlining their interest in joining the NGO Forum, which is considered a minor documentation gap in the membership application.'
            ],

            'mission_vision' => [
                'yes' => '{ORG} provided a clear mission and/or vision statement that outlines the organization’s long-term goals, values, and strategic direction, which aligns with the principles of the NGO Forum.',
                'no'  => '{ORG} did not provide a mission and/or vision statement, making it difficult to assess the organization’s strategic direction and long-term objectives.'
            ],

            'constitution' => [
                'yes' => '{ORG} submitted their constitution and/or by-laws as per membership requirements, demonstrating a clearly defined governance structure, organizational mandate, and internal management framework.',
                'no'  => '{ORG} did not submit their constitution and/or by-laws, which limits the ability to assess the organization’s governance structure and legal framework.'
            ],

            'activities' => [
                'yes' => '{ORG} provided a comprehensive list of current activities and relevant brochures, demonstrating active engagement in development work and alignment with the thematic areas of the NGO Forum.',
                'no'  => '{ORG} did not provide sufficient documentation on their activities and brochures, which restricts a full assessment of their operational scope and programmatic experience.'
            ],

            'funding' => [
                'yes' => '{ORG} listed their funding sources and board members, indicating a level of financial transparency and organizational accountability required for NGO Forum membership.',
                'no'  => '{ORG} did not clearly list their funding sources and decision-makers, which limits the assessment of financial transparency and governance arrangements.'
            ],

            'authorization' => [
                'yes' => '{ORG} demonstrated valid authorization to operate through official documentation, confirming their legal registration and compliance with national regulatory requirements.',
                'no'  => '{ORG} did not provide valid authorization to operate, raising concerns regarding legal registration and regulatory compliance.'
            ],

            'strategic_plan' => [
                'yes' => '{ORG} presented their strategic plan, outlining organizational priorities, planned interventions, and long-term development objectives.',
                'no'  => '{ORG} did not submit a strategic plan, which limits the evaluation of the organization’s long-term planning and strategic direction.'
            ],

            'fundraising_strategy' => [
                'yes' => '{ORG} provided information on their fundraising strategy, demonstrating efforts to ensure financial sustainability and resource mobilization.',
                'no'  => '{ORG} did not provide a separate fundraising strategy; however, this requirement is not compulsory and is considered a minor gap.'
            ],

            'audit_report' => [
                'yes' => '{ORG} submitted their audited financial report, providing evidence of financial accountability, transparency, and compliance with accepted financial management standards.',
                'no'  => '{ORG} did not submit an audited financial report, which limits the assessment of financial accountability and transparency.'
            ],
        ];
    }
}
