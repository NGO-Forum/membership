<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventCreatedMail;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);

        $startOfMonth = Carbon::create($year, $month, 1);
        $gridStart = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd = $startOfMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $events = Event::with(['files', 'images'])
            ->whereDate('start_date', '<=', $gridEnd)
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
            'event_type' => 'required|in:ngof,invite',
            'organization_invite' => 'nullable|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'location'    => 'nullable|string|max:255',
            'organizer'   => 'nullable|string|max:255',
            'organizer_email' => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:20',
            'registration_close_date' => 'nullable|date',
            'files' => 'nullable|array|max:10',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',

            'images' => 'nullable|array|max:3',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        // program logic
        if ($user->isProgram()) {
            $data['program'] = $user->role;
        }

        if ($user->isAdmin()) {
            $data['program'] = $request->program ?? 'admin';
        }

        // ✅ NOW title exists
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
        if ($event->event_type === 'ngof') {
            $registrationLink = route('events.register', $event->id);
            $event->registration_link = $registrationLink;

            $qr = QrCode::create($registrationLink)->setSize(300);
            $writer = new PngWriter();
            $result = $writer->write($qr);

            $fileName = 'qrcodes/event_' . $event->id . '.png';
            Storage::disk('public')->put($fileName, $result->getString());

            $event->qr_code_path = $fileName;
        } else {
            $event->registration_link = null;
            $event->qr_code_path = null;
            $event->registration_close_date = null;
        }

        $event->save();

        // ✉️ Send email to organizer
        if ($event->event_type === 'ngof' && $event->organizer_email) {
            Mail::to($event->organizer_email)
                ->send(new EventCreatedMail($event));
        }

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
                'event_type' => $event->event_type,
                'organization_invite' => $event->organization_invite,
                'start_date' => $event->start_date->toDateString(),
                'end_date' => $event->end_date->toDateString(),
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'location' => $event->location,
                'organizer' => $event->organizer,
                'organizer_email' => $event->organizer_email,
                'phone' => $event->phone,
                'registration_close_date' => $event->registration_close_date,
                'description' => $event->description,


                'files' => $event->files->map(fn($file) => [
                    'file_name' => $file->file_name,
                    'url' => asset('storage/' . $file->file_path),
                ]),
            ]),
        ]);
    }

    public function sendEmail(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'message'  => 'required|string|max:2000',
        ]);

        $event = Event::findOrFail($data['event_id']);

        // Only invite events
        if ($event->event_type !== 'invite') {
            return response()->json([
                'message' => 'Only invite events can receive messages.'
            ], 403);
        }

        if (!$event->organizer_email) {
            return response()->json([
                'message' => 'Organizer email not available.'
            ], 404);
        }

        try {
            Mail::send([], [], function ($mail) use ($event, $data) {

                $mail->to($event->organizer_email)
                    ->replyTo($data['email'], $data['name']) // 🔥 important
                    ->subject("📩 New Message: {$event->title}")
                    ->html("
                    <div style='font-family: Arial, sans-serif; line-height:1.6'>
                        <h2 style='color:#16a34a;'>New Message from Event</h2>

                        <p><strong>Event:</strong> {$event->title}</p>

                        <hr>

                        <p><strong>Sender Name:</strong> {$data['name']}</p>
                        <p><strong>Email:</strong> {$data['email']}</p>

                        <p><strong>Message:</strong></p>
                        <div style='padding:10px; background:#f3f4f6; border-radius:6px'>
                            {$data['message']}
                        </div>

                        <br>

                        <small style='color:#888'>
                            This message was sent from NGOF Event System
                        </small>
                    </div>
                ");
            });

            return response()->json([
                'message' => 'Email sent successfully'
            ]);
        } catch (\Exception $e) {

            Log::error('Send email failed', [
                'error' => $e->getMessage(),
                'event_id' => $event->id
            ]);

            return response()->json([
                'message' => 'Failed to send email'
            ], 500);
        }
    }
}
