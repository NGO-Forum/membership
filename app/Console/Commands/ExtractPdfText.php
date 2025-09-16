<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\PdfToText\Pdf;
use Illuminate\Support\Facades\Storage;

class ExtractPdfText extends Command
{
    protected $signature = 'pdf:extract {file}';
    protected $description = 'Extract text from a PDF file using Poppler';

    public function handle()
    {
        $file = $this->argument('file');

        $filePath = Storage::disk('public')->path($file);

        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $binaryPath = 'C:/poppler/Library/bin/pdftotext.exe';

        if (!file_exists($binaryPath)) {
            $this->error("Poppler binary not found at {$binaryPath}");
            return 1;
        }

        try {
            $pdf = new Pdf($binaryPath);
            $text = $pdf->getText($filePath);
            $this->info("Extracted text:\n\n" . $text);
        } catch (\Exception $e) {
            $this->error("Error extracting text: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
