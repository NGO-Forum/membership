<?php

namespace App\Http\Controllers;

use App\Models\MembershipUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use PhpOffice\PhpWord\IOFactory;
use thiagoalessio\TesseractOCR\TesseractOCR;

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

        $files = [
            'letter',
            'mission_vision',
            'constitution',
            'activities',
            'funding',
            'authorization',
            'strategic_plan',
            'fundraising_strategy',
            'audit_report'
        ];

        $allText = '';

        foreach ($files as $field) {
            $filePath = $membership->{$field} ? Storage::disk('public')->path($membership->{$field}) : null;

            if ($filePath && file_exists($filePath)) {
                $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                $text = $this->extractText($filePath, $extension);

                // ✅ Ensure UTF-8 encoding for Khmer/English
                $text = mb_convert_encoding($text, 'UTF-8', 'auto');

                // ✅ Clean newlines and spaces
                $text = preg_replace("/[\r\n]+/", "\n", trim($text));
                $text = preg_replace("/\s{2,}/", " ", $text);

                // ✅ Keep only Khmer + English + numbers + punctuation
                $text = preg_replace('/[^\p{L}\p{N}\p{P}\p{Z}\x{1780}-\x{17FF}\n]/u', '', $text);

                $allText .= $text . "\n\n";
            }
        }

        // Wrap everything in a single key
        $jsonToSave = ['data' => $allText];

        $membershipId = $membership->new_membership_id ?? $membership->id;
        $folderName = 'membershipJSON';
        $folderPath = storage_path('app/public/' . $folderName);

        if (!file_exists($folderPath)) mkdir($folderPath, 0755, true);

        // ✅ Save with UTF-8 BOM so Khmer shows correctly in editors
        file_put_contents(
            $folderPath . '/membership_' . $membershipId . '.json',
            "\xEF\xBB\xBF" . json_encode($jsonToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );


        return redirect()->route('membership.thankyou');
    }

    /**
     * Extract text from PDF or DOCX files.
     */
    private function extractText(string $filePath, string $extension): string
    {
        $text = '';

        if ($extension === 'pdf') {
            // Try pdftotext first
            $binaryPath = 'C:\\poppler\\Library\\bin\\pdftotext.exe';
            if (!file_exists($binaryPath)) {
                throw new \Exception("pdftotext binary not found at: {$binaryPath}");
            }

            // -enc UTF-8 ensures Khmer extraction if PDF has Unicode
            $command = "\"{$binaryPath}\" -layout -enc UTF-8 \"{$filePath}\" -";
            $text = shell_exec($command);

            // If empty or garbled, fallback to OCR
            if (empty(trim($text))) {
                $text = (new TesseractOCR($filePath))
                    ->lang('khm+eng') // Khmer + English
                    ->run();
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

        // Ensure UTF-8
        return mb_convert_encoding(trim($text), 'UTF-8', 'auto');
    }
    
}
