<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewMembership;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;


class MembershipReportController extends Controller
{
    public function index()
    {
        $newMemberships = NewMembership::where('status', 'approved')->with(['user'])->get();
        return view('reports.membership', compact('newMemberships'));
    }

    public function show($id)
    {
        // Load membership with uploads, networks, and focal points
        $membership = NewMembership::with([
            'membershipUploads.networks',
            'membershipUploads.focalPoints'
        ])->findOrFail($id);

        $upload = $membership->membershipUploads->first();

        // Prepare scores for uploaded files
        $fields = [
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

        $scores = [];
        foreach ($fields as $field) {
            $scores[$field] = ($upload && $upload->{$field}) ? Storage::url($upload->{$field}) : null;
        }

        // Prepare networks with focal points
        $networkData = $upload ? $upload->networks->map(function ($network) use ($upload) {
            $focalPoints = $upload->focalPoints
                ->where('network_name', $network->network_name)
                ->map(fn($fp) => [
                    'name' => $fp->name,
                    'position' => $fp->position,
                    'email' => $fp->email,
                    'phone' => $fp->phone,
                    'sex' => $fp->sex,
                ])->toArray();

            return [
                'network_name' => $network->network_name,
                'focal_points' => $focalPoints
            ];
        }) : collect();

        // Extract membership JSON text if exists
        $membershipId = $membership->id;
        $jsonFile = storage_path("app/public/membershipJSON/membership_{$membershipId}.json");
        $text = '';
        if (file_exists($jsonFile)) {
            $content = file_get_contents($jsonFile);
            $content = preg_replace('/^\x{FEFF}/u', '', $content);
            $jsonData = json_decode($content, true);
            $text = $jsonData['data'] ?? '';
        }

        // Blade template variables
        $visionText = $membership->vision_text ?? 'N/A';
        $missionText = $membership->mission_text ?? 'N/A';
        $addressText = $membership->address ?? 'N/A';
        $typeNgo = $membership->type_ngo ?? 'N/A';

        // Key actions
        $keyActions = [];
        if (!empty($membership->key_actions)) {
            if (is_string($membership->key_actions)) {
                $keyActions = json_decode($membership->key_actions, true) ?: [];
            } elseif (is_array($membership->key_actions)) {
                $keyActions = $membership->key_actions;
            }
        }

        // Uploaded files: just names
        $uploadedFilesText = '';
        foreach ($fields as $field) {
            if ($upload->{$field}) {
                $uploadedFilesText .= ucfirst(str_replace('_', ' ', $field)) . "\n";
            }
        }

        // Networks: only summary
        $networkSummary = $networkData->pluck('network_name')->implode(', ');

        // Membership text: only first 500 chars (or summary)
        $membershipSummary = substr($text, 0, 500);


        // Optional AI report generation
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are an evaluator who produces NGO membership assessment reports in a fixed template format."
                ],
                [
                    'role' => 'user',
                    'content' => "
                Generate an NGO membership assessment report using the following fixed structure. 
                Use professional wording but keep the format exactly:

                1. Summary  
                - Overview of organization  
                - Key strengths  
                - Minor gaps  

                2. Information about Applicant  
                - Name  
                - Type of NGO  
                - Vision  
                - Mission  
                - Year Established  
                - Address  
                - Director  
                - Key Actions  

                3. Checklist of Requirements  
                Table with: Item | Description | Rating (1–5) | Comments | Files  

                4. Type of Membership / Fee  

                5. Interest in Attending Network Meetings  

                6. Conclusions and Recommendations  
                - Strengths  
                - Minor gaps  
                - Final recommendation  

                Then close with **Reviewed by / Submitted by / Endorsed by** signatures (placeholders if not in data).
                "
                ],
            ],
            'max_tokens' => 16384,
        ]);

        $reportText = $response->choices[0]->message->content ?? '';



        return view('reports.show', compact(
            'membership',
            'scores',
            'networkData',
            'visionText',
            'missionText',
            'addressText',
            'typeNgo',
            'keyActions',
            'reportText'
        ));
    }
}
