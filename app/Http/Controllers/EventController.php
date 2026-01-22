<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventInterestMail;
use App\Models\User;

class EventController extends Controller
{
    private function authorizeProgram(Event $event)
    {
        $user = auth()->user();

        // ✅ Admin can do EVERYTHING
        if ($user->isAdmin()) {
            return;
        }

        // ❌ Program users can ONLY access their own program
        if ($user->isProgram() && $event->program !== $user->role) {
            abort(403, 'Unauthorized access to this event.');
        }
    }

    public function index()
    {
        $user = auth()->user();

        $query = Event::with(['files', 'images'])
            ->whereDate('end_date', '>=', Carbon::today());

        // Program sees only own
        if ($user->isProgram()) {
            $query->where('program', $user->role);
        }

        $events = $query->orderBy('id', 'desc')->get();

        return view('events.newEvent', compact('events'));
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
            'phone' => 'nullable|string|max:20',
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

        return redirect()->route('events.newEvent')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $this->authorizeProgram($event);

        if (request()->ajax()) {
            return response()->json($event);
        }

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeProgram($event);

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
            'files.*'     => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $event->update($request->only([
            'title',
            'description',
            'start_date',
            'end_date',
            'start_time',
            'end_time',
            'location',
            'organizer',
            'organizer_email',
            "phone",
        ]));

        // ✅ Files (only if new ones uploaded)
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('events/files', 'public');
                $event->files()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        // ✅ Images (only if new ones uploaded)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('events/images', 'public');
                $event->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('events.newEvent')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeProgram($event);

        $event->delete();
        return redirect()->route('events.newEvent')->with('success', 'Event deleted successfully.');
    }

    // ✅ API JSON endpoint (cleaner for JS)
    public function getEvent(Event $event)
    {
        $event->load(['files', 'images']); // important!

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'start_date' => $event->start_date,
            'end_date' => $event->end_date,
            'start_time' => $event->start_time,
            'end_time' => $event->end_time,
            'location' => $event->location,
            'organizer' => $event->organizer,
            'organizer_email' => $event->organizer_email,
            'phone' => $event->phone,
            'files' => $event->files->map(fn($file) => [
                'file_name' => $file->file_name,
                'file_path' => $file->file_path,
                'file_type' => $file->file_type,
            ]),
            'images' => $event->images->map(fn($img) => [
                'image_path' => $img->image_path,
            ]),
        ]);
    }


    public function showPast()
    {
        $user = auth()->user();

        $query = Event::with(['files', 'images'])
            ->whereDate('end_date', '<', Carbon::today());

        if ($user->isProgram()) {
            $query->where('program', $user->role);
        }

        $events = $query->orderBy('id', 'desc')->get();

        return view('events.pastEvent', compact('events'));
    }

    public function register()
    {
        $events = Event::orderBy('id', 'desc')->get();
        return view('events.qr', compact('events'));
    }

    public function downloadQr(Event $event)
    {
        $this->authorizeProgram($event);

        if (!$event->qr_code_path || !Storage::disk('public')->exists($event->qr_code_path)) {
            return redirect()->back()->with('error', 'QR code not available for this event.');
        }

        $fileName = 'QR-' . Str::slug($event->title) . '.png';

        $filePath = storage_path('app/public/' . $event->qr_code_path);

        return response()->download($filePath, $fileName);
    }

    // ✅ Add files to event (store in storage, save path in DB)
    public function addFiles(Request $request, Event $event)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $files = $request->file('files') ?? [];
        $existing = $event->files()->count();

        if ($existing + count($files) > 10) {
            return back()->with('error', 'Max 10 files allowed.');
        }

        foreach ($files as $file) {
            $path = $file->store('events/files', 'public'); // saved in storage/app/public/events/files
            $event->files()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
            ]);
        }

        return back()->with('success', 'Files added successfully.');
    }

    // ✅ Add images to event (store in storage, save path in DB)
    public function addImages(Request $request, Event $event)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $images = $request->file('images') ?? [];
        $existing = $event->images()->count();

        if ($existing + count($images) > 3) {
            return back()->with('error', 'Max 3 images allowed.');
        }

        foreach ($images as $image) {
            $path = $image->store('events/images', 'public');
            $event->images()->create([
                'image_path' => $path,
            ]);
        }

        return back()->with('success', 'Images added successfully.');
    }


    public function newEvent()
    {
        $events = Event::with(['files', 'images'])->whereDate('end_date', '>=', Carbon::today())
            ->orderBy('id', 'desc')
            ->get();

        return view('events.userEvent', compact('events'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'event_id' => 'required|exists:events,id',
        ]);

        $event = Event::findOrFail($request->event_id);

        // Organizer email: from DB or a default
        $organizerEmail = $event->organizer_email;

        Mail::to($event->organizer_email ?? 'info@ngoforum.org.kh')
            ->send(new EventInterestMail(
                $event,
                $request->name,
                $request->email,
                $request->message
            ));

        return back()->with('success', 'Message sent successfully.');
    }
}
