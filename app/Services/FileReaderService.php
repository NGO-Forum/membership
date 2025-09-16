<?php

namespace App\Services;

use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;

class FileReaderService
{
    public function readFile(string $relativePath): string
    {
        // Always resolve to full storage path
        $filePath = storage_path('app/' . $relativePath);

        if (!file_exists($filePath)) {
            return ''; // File missing
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        switch ($extension) {
            case 'docx':
                return $this->readDocx($filePath);
            case 'pdf':
                return $this->readPdf($filePath);
            default:
                return file_get_contents($filePath) ?: '';
        }
    }

    private function readDocx(string $filePath): string
    {
        $phpWord = IOFactory::load($filePath);
        $text = '';

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= $element->getText() . "\n";
                }
            }
        }

        return $text;
    }

    private function readPdf(string $filePath): string
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($filePath);
        return $pdf->getText();
    }

    public function evaluateFile(string $relativePath, array $keywords): array
    {
        $text = $this->readFile($relativePath);

        if (!$text) {
            return [
                'score' => 3,
                'comments' => "No content found or file missing."
            ];
        }

        foreach ($keywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                return [
                    'score' => 5,
                    'comments' => "File contains relevant information (found: {$keyword})."
                ];
            }
        }

        return [
            'score' => 3,
            'comments' => "File submitted but expected keywords not found."
        ];
    }
}
