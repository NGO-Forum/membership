<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Ngo;
use App\Models\NewMembership;
use App\Models\Membership;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{

    private function authorizeProgram(Event $event)
    {
        $user = auth()->user();

        // 👑 Admin can do everything
        if ($user->isAdmin()) {
            return;
        }

        // ❌ Program can access only own program
        if ($user->isProgram() && $event->program !== $user->role) {
            abort(403, 'Unauthorized access.');
        }
    }


    public function create(Event $event)
    {
        return view('registrations.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'gender'         => 'nullable|in:Male,Female',
            'age'            => 'nullable|integer|min:1|max:120',
            'vulnerable'     => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'nullable|string|max:20',
            'organization'   => 'nullable|string|max:255',
            'position'       => 'nullable|string|max:255',
            'org_location'   => 'nullable|string|max:255',
            'signature'      => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'allow_photos'   => 'nullable|boolean',
        ]);

        /* ================= FIND ORGANIZATION ================= */

        $ngo = null;
        $newMembership = null;
        $membership = null;

        if (!empty($validated['organization'])) {

            $ngo = Ngo::where('ngo_name', $validated['organization'])
                ->orWhere('abbreviation', $validated['organization'])
                ->first();

            $newMembership = NewMembership::where('org_name_en', $validated['organization'])
                ->first();

            if ($ngo) {
                $membership = Membership::where('ngo_name', $ngo->ngo_name)
                    ->orWhere('ngo_name', $ngo->abbreviation)
                    ->first();
            }
        }

        /* ================= SIGNATURE UPLOAD ================= */

        $signaturePath = null;
        if ($request->hasFile('signature')) {
            $signaturePath = $request->file('signature')
                ->store('signatures', 'public');
        }

        /* ================= SAVE REGISTRATION ================= */

        Registration::create([
            'event_id'          => $event->id,
            'name'              => $validated['name'],
            'gender'            => $validated['gender'] ?? null,
            'age'               => $validated['age'] ?? null,
            'vulnerable'        => $validated['vulnerable'],
            'email'             => $validated['email'],
            'phone'             => $validated['phone'] ?? null,
            'organization'      => $validated['organization'] ?? null,
            'position'          => $validated['position'] ?? null,
            'org_location'      => $validated['org_location'] ?? null,
            'signature'         => $signaturePath,
            'allow_photos'      => $request->boolean('allow_photos'),
            'ngo_id'            => $ngo?->id,
            'new_membership_id' => $newMembership?->id,
            'membership_id'     => $membership?->id,
        ]);

        return redirect()
            ->route('registrations.thank', $event->id)
            ->with('success', 'You have registered successfully!');
    }

    /* ================= ADMIN ================= */

    public function index()
    {
        $user = auth()->user();

        $query = Event::with('registrations')
            ->orderBy('end_date', 'desc');

        // Program sees only own events
        if ($user->isProgram()) {
            $query->where('program', $user->role);
        }

        $events = $query->get();

        return view('registrations.index', compact('events'));
    }


    public function show($eventId)
    {
        $event = Event::with('registrations')->findOrFail($eventId);

        $this->authorizeProgram($event);

        return view('registrations.showAll', [
            'event' => $event,
            'registrations' => $event->registrations
        ]);
    }

    public function edit(Registration $registration)
    {
        $this->authorizeProgram($registration->event);

        return view('registrations.edit', compact('registration'));
    }

    /* ================= AJAX CREATE ================= */
    public function storeAjax(Request $request, Event $event)
    {
        $this->authorizeProgram($event);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
            'position'     => 'nullable|string|max:255',
            'age'          => 'nullable|integer|min:1|max:120',
            'gender'       => 'nullable|in:Male,Female',
            'vulnerable'   => 'nullable|string|max:255',
            'org_location' => 'nullable|string|max:255',
            'allow_photos'   => 'nullable|boolean',
        ]);

        $registration = $event->registrations()->create($validated);

        return response()->json([
            'success' => true,
            'data' => $registration
        ]);
    }

    /* ================= AJAX UPDATE ================= */
    public function updateAjax(Request $request, Registration $registration)
    {
        $this->authorizeProgram($registration->event);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
            'position'     => 'nullable|string|max:255',
            'age'          => 'nullable|integer|min:1|max:120',
            'gender'       => 'nullable|in:Male,Female',
            'vulnerable'   => 'nullable|string|max:255',
            'org_location' => 'nullable|string|max:255',
            'allow_photos'   => 'nullable|boolean',
        ]);

        $registration->update($validated);

        return response()->json([
            'success' => true,
            'data' => $registration
        ]);
    }


    public function destroy(Registration $registration)
    {
        $this->authorizeProgram($registration->event);

        $registration->delete();

        return back()->with('success', 'Registration deleted.');
    }



    public function thankYou()
    {
        return view('registrations.thank');
    }

    // public function exportPdf(Event $event)
    // {
    //     $registrations = Registration::where('event_id', $event->id)->get();

    //     $fileName = 'Attendant_List_' . Str::slug($event->title) . '.pdf';

    //     return Pdf::loadView('registrations.export-pdf', [
    //         'event' => $event,
    //         'registrations' => $registrations,
    //     ])
    //         ->setPaper('a4', 'landscape')
    //         ->download($fileName);
    // }
}
