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
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);

        $startOfMonth = Carbon::create($year, $month, 1);
        $gridStart = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd = $startOfMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $events = Event::whereDate('start_date', '<=', $gridEnd)
            ->whereDate('end_date', '>=', $gridStart)
            ->get();


        return view('events.calendar', compact('events', 'startOfMonth', 'gridStart', 'gridEnd'));
    }

    private function calendarEvents(int $month, int $year)
    {
        $startOfMonth = Carbon::create($year, $month, 1);
        $gridStart = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd = $startOfMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $events = Event::with('images')
            ->where(function ($query) use ($gridStart, $gridEnd) {
                $query->whereBetween('start_date', [$gridStart, $gridEnd])
                    ->orWhereBetween('end_date', [$gridStart, $gridEnd])
                    ->orWhere(function ($q) use ($gridStart, $gridEnd) {
                        $q->where('start_date', '<=', $gridStart)
                            ->where('end_date', '>=', $gridEnd);
                    });
            })
            ->orderBy('start_date')
            ->get();

        return [$events, $startOfMonth, $gridStart, $gridEnd];
    }


    public function store(Request $request)
    {
        // ✅ 1. ALWAYS capture validated data
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'location'    => 'nullable|string|max:255',
            'organizer'   => 'nullable|string|max:255',
            'organizer_email' => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:20',
            'files.*'     => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        // 🔐 Program users → force program
        if ($user->isProgram()) {
            $data['program'] = $user->role;
        }

        // 👑 Admin → must choose program (or fallback)
        if ($user->isAdmin()) {
            $data['program'] = $request->program ?? 'admin';
            // ↑ OR show program dropdown in UI
        }

        // ✅ 2. Create event (NOW WORKS)
        $event = Event::create(
            collect($data)->except(['files', 'images'])->toArray()
        );

        /* ---------- Files (max 10) ---------- */
        if ($request->hasFile('files')) {
            if (count($request->file('files')) > 10) {
                return back()->with('error', 'You can upload maximum 10 files.');
            }

            foreach ($request->file('files') as $file) {
                $path = $file->store('events/files', 'public');
                $event->files()->create([
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        /* ---------- Images (max 3) ---------- */
        if ($request->hasFile('images')) {
            if (count($request->file('images')) > 3) {
                return back()->with('error', 'You can upload maximum 3 images.');
            }

            foreach ($request->file('images') as $image) {
                $path = $image->store('events/images', 'public');
                $event->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        /* ---------- QR Code ---------- */
        $registrationLink = route('events.register', $event->id);
        $event->registration_link = $registrationLink;

        $qr = QrCode::create($registrationLink)->setSize(300);
        $writer = new PngWriter();
        $result = $writer->write($qr);

        $fileName = 'qrcodes/event_' . $event->id . '.png';
        Storage::disk('public')->put($fileName, $result->getString());

        $event->qr_code_path = $fileName;
        $event->save();

        return redirect()
            ->route('events.calendar')
            ->with('success', 'Event created successfully!');
    }


    /* ================= API (REACT) ================= */
    public function api(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        [$events,, $gridStart, $gridEnd] =
            $this->calendarEvents($month, $year);

        return response()->json([
            'month' => $month,
            'year' => $year,
            'grid_start' => $gridStart->toDateString(),
            'grid_end' => $gridEnd->toDateString(),
            'events' => $events->map(fn($event) => [
                'id' => $event->id,
                'title' => $event->title,
                'start_date' => $event->start_date->toDateString(),
                'end_date' => $event->end_date->toDateString(),
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'location' => $event->location,
                'organizer' => $event->organizer,
                'organizer_email' => $event->organizer_email,
                'phone' => $event->phone,
                'description' => $event->description,

                // ✅ REGISTER LINK (ONE BY ONE)
                'registration_link' => $event->registration_link
                    ?? route('events.register', $event->id),
                'images' => $event->images->map(fn($img) => [
                    'url' => asset('storage/' . $img->image_path),
                ]),
            ]),
        ]);
    }
}
