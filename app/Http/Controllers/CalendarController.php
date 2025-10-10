<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);

        $startOfMonth = Carbon::create($year, $month, 1);
        $gridStart = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd = $startOfMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $events = Event::where(function ($query) use ($gridStart, $gridEnd) {
            $query->whereBetween('start_date', [$gridStart, $gridEnd])
                ->orWhereBetween('end_date', [$gridStart, $gridEnd])
                ->orWhere(function ($q) use ($gridStart, $gridEnd) {
                    $q->where('start_date', '<=', $gridStart)
                        ->where('end_date', '>=', $gridEnd);
                });
        })
            ->get();


        return view('events.calendar', compact('events', 'startOfMonth', 'gridStart', 'gridEnd'));
    }

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
            'files.*'     => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $event = Event::create($request->except(['files', 'images']));

        // Handle files (max 10)
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            if (count($files) > 10) {
                return back()->with('error', 'You can upload maximum 10 files.');
            }
            foreach ($files as $file) {
                $path = $file->store('events/files', 'public');
                $event->files()->create([
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Handle images (max 3)
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            if (count($images) > 3) {
                return back()->with('error', 'You can upload maximum 3 images.');
            }
            foreach ($images as $image) {
                $path = $image->store('events/images', 'public');
                $event->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        $registrationLink = route('events.register', $event->id);
        $event->registration_link = $registrationLink;

        // 3. Generate QR code with Endroid
        $qr = QrCode::create($registrationLink)->setSize(300);
        $writer = new PngWriter();
        $result = $writer->write($qr);

        // 4. Save QR code file in storage/public/qrcodes
        $fileName = 'qrcodes/event_' . $event->id . '.png';
        Storage::disk('public')->put($fileName, $result->getString());

        // 5. Save path to DB
        $event->qr_code_path = $fileName;
        $event->save();
        return redirect()->route('events.calendar')->with('success', 'Event created successfully!');
    }
}
