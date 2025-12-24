<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year  = (int) $request->query('year', now()->year);

        $startOfMonth = Carbon::create($year, $month, 1);
        $gridStart = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd   = $startOfMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        // ✅ CORRECT EVENT FETCH
        $events = Event::with(['files', 'images'])
            ->whereDate('end_date', '>=', $gridStart)
            ->whereDate('start_date', '<=', $gridEnd)
            ->get();

        return view('events.calendar', compact(
            'events',
            'startOfMonth',
            'gridStart',
            'gridEnd'
        ));
    }

    /* ================= STORE EVENT ================= */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'location'    => 'nullable|string|max:255',
            'organizer'   => 'nullable|string|max:255',
            'organizer_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'files.*'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $event = Event::create($request->except(['files', 'images']));

        /* -------- FILES -------- */
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('events/files', 'public');
                $event->files()->create([
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        /* -------- IMAGES -------- */
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('events/images', 'public');
                $event->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        /* -------- REGISTRATION LINK + QR -------- */
        $event->registration_link = route('events.register', $event->id);

        $qr = QrCode::create($event->registration_link)->setSize(300);
        $writer = new PngWriter();
        $result = $writer->write($qr);

        $qrPath = "qrcodes/event_{$event->id}.png";
        Storage::disk('public')->put($qrPath, $result->getString());

        $event->qr_code_path = $qrPath;
        $event->save();

        return redirect()
            ->route('events.calendar')
            ->with('success', 'Event created successfully!');
    }

    /* ================= API (REACT) ================= */
    public function api(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year  = (int) $request->query('year', now()->year);

        $startOfMonth = Carbon::create($year, $month, 1);
        $gridStart = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd   = $startOfMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $events = Event::with('images')
            ->whereDate('end_date', '>=', $gridStart)
            ->whereDate('start_date', '<=', $gridEnd)
            ->get();

        return response()->json([
            'month' => $month,
            'year' => $year,
            'grid_start' => $gridStart->toDateString(),
            'grid_end'   => $gridEnd->toDateString(),
            'events' => $events->map(fn ($event) => [
                'id' => $event->id,
                'title' => $event->title,
                'start_date' => $event->start_date->toDateString(),
                'end_date'   => $event->end_date->toDateString(),
                'start_time' => $event->start_time,
                'end_time'   => $event->end_time,
                'location'  => $event->location,
                'organizer' => $event->organizer,
                'organizer_email' => $event->organizer_email,
                'phone' => $event->phone,
                'description' => $event->description,
                'registration_link' => $event->registration_link,
                'images' => $event->images->map(fn ($img) => [
                    'url' => asset('storage/' . $img->image_path),
                ]),
            ]),
        ]);
    }
}
