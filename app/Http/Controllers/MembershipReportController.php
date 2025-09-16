<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewMembership;
use Spatie\PdfToText\Pdf;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;


class MembershipReportController extends Controller
{
    public function index()
    {
        $newMemberships = NewMembership::where('status', 'approved')
            ->with(['user'])
            ->get();

        return view('reports.membership', compact('newMemberships'));
    }

    public function show($id)
    {
        $membership = NewMembership::with([
            'membershipUploads.networks',
            'membershipUploads.focalPoints'
        ])->findOrFail($id);

        $upload = $membership->membershipUploads->first();

        // Path to stored JSON
        $membershipId = $membership->new_membership_id ?? $membership->id;
        $jsonFile = storage_path('app/public/membershipJSON/membership_' . $membershipId . '.json');
        $jsonData = [];

        if (file_exists($jsonFile)) {
            $content = file_get_contents($jsonFile);
            $content = preg_replace('/^\x{FEFF}/u', '', $content);
            $jsonData = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                dd('JSON Error: ' . json_last_error_msg());
            }
            // dd($jsonData);
        }

        // Extract Vision / Mission
        $visionText = null;
        $missionText = null;
        $addressText = null;
        $typeNgo = null;
        $keyActions = [];

        if (!empty($jsonData['data'])) {
            $text = $jsonData['data'];

            //Vision
            preg_match('/Vision\s*[:\-]?\s*([\s\S]*?).(?=Mission|$)/i', $text, $visionMatches);
            $visionText = $visionMatches[1] ?? null;

            //Mission
            preg_match('/Mission\s*[:\-]?\s*([\s\S]*?).(?=Core Values|$)/i', $text, $missionMatches);
            $missionText = $missionMatches[1] ?? null;

            //Address
            if (preg_match('/(#\d+.*Cambodia)/', $text, $matches)) {
                $addressText = trim($matches[1]);
            }

            // Extract Core Values / Key Actions (if available)
            if (preg_match('/Core Values\s*(.*?)\s*(www\.|#\d+|\d{3}\s\d{3}\s\d{3})/s', $text, $matches)) {
                $lines = preg_split("/\r\n|\n|\r/", $matches[1]);
                $keyActions = array_filter(array_map(function ($line) {
                    return trim(str_replace(['•', '• '], '', $line));
                }, $lines));
            }

            if (preg_match('/(#?\d*.*(?:Cambodia|Thailand|Vietnam|Singapore|Malaysia|...))/i', $text, $matches)) {
                $typeNgo = trim($matches[1]);
            }
        }

        // Score uploaded fields
        $fields = [
            'letter',
            'mission_vision',
            'constitution',
            'typeNgo',
            'activities',
            'funding',
            'authorization',
            'strategic_plan',
            'fundraising_strategy',
            'audit_report',
            'logo'
        ];

        foreach ($fields as $field) {
            if (optional($upload)->{$field}) {
                $membership->{$field . '_score'} = 5;
                $membership->{$field . '_comments'} = "File submitted.";
            } else {
                $membership->{$field . '_score'} = 3;
                $membership->{$field . '_comments'} = "File missing.";
            }
        }

        // Aggregate scores
        $scores = collect([
            $membership->letter_score,
            $membership->mission_vision_score,
            $membership->constitution_score,
            $membership->activities_score,
            $membership->funding_score,
            $membership->authorization_score,
            $membership->strategic_plan_score,
            $membership->fundraising_strategy_score,
            $membership->audit_report_score,
        ]);

        $hasScore5 = $scores->contains(5);
        $hasScore3 = $scores->contains(3);

        // Pass JSON + extracted points to Blade
        return view('reports.show', compact(
            'membership',
            'visionText',
            'missionText',
            'addressText',
            'keyActions',
        ));
    }




    /**
     * Extract text from PDF or DOCX files.
     */
    private function extractText(string $filePath, string $extension): string
    {
        $text = '';

        if ($extension === 'pdf') {
            // Correct binary path (make sure it matches your system)
            $binaryPath = 'C:\\poppler\\Library\\bin\\pdftotext.exe';

            if (!file_exists($binaryPath)) {
                throw new \Exception("Binary not found at: {$binaryPath}");
            }

            // Run pdftotext with -layout (keeps formatting) and output to stdout (-)
            $command = "\"{$binaryPath}\" -layout \"{$filePath}\" -";
            $text = shell_exec($command);

            if (empty($text)) {
                throw new \Exception("Failed to extract text from PDF: {$filePath}");
            }
        } elseif ($extension === 'docx') {
            $phpWord = IOFactory::load($filePath);
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                        foreach ($element->getElements() as $textElement) {
                            if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                $text .= $textElement->getText() . ' ';
                            }
                        }
                    } elseif ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                        $text .= $element->getText() . ' ';
                    }
                }
            }
        } else {
            throw new \Exception("Unsupported file format: {$extension}");
        }

        return trim($text);
    }
}
