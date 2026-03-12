<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Str;
use Mpdf\Mpdf;

class AttendantPdfController extends Controller
{
    public function exportPdf(Event $event)
    {
        $registrations = Registration::where('event_id', $event->id)->get();

        $tempDir = storage_path('app/mpdf');

        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0775, true);
        }

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_left'   => 12,
            'margin_right'  => 12,
            'tempDir'       => $tempDir,

            // Khmer language mode
            'autoScriptToLang' => true,
            'autoLangToFont'   => true,

            // Khmer font
            'default_font' => 'khmeros',
        ]);

        $mpdf->SetFooter('Page {PAGENO}');

        $html = view('registrations.export-pdf', [
            'event' => $event,
            'registrations' => $registrations,
        ])->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output(
            'Attendant_List_' . Str::slug($event->title) . '.pdf',
            'D'
        );
    }
}