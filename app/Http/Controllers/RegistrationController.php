<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Ngo;
use App\Models\NewMembership;
use App\Models\Membership;

class RegistrationController extends Controller
{
    public function create(Event $event)
    {
        return view('registrations.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'gender' => 'nullable|in:Male,Female',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        $organizationInput = $request->organization;

        $ngo = null;
        $newMembership = null;
        $oldMembership = null;

        if ($organizationInput) {
            // Find NGO by name or abbreviation
            $ngo = Ngo::where('ngo_name', $organizationInput)
                ->orWhere('abbreviation', $organizationInput)
                ->first();

            $newMembership = NewMembership::where('org_name_en', $organizationInput)->first();
            
            if ($ngo) {

                // Find old membership
                $oldMembership = Membership::where('ngo_name', $ngo->ngo_name)
                    ->orWhere('ngo_name', $ngo->abbreviation)
                    ->first();
            }
        }

        $registration = Registration::create([
            'event_id' => $event->id,
            'name'     => $request->name,
            'gender'   => $request->gender,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'organization' => $organizationInput,
            'position' => $request->position,
            'ngo_id' => $ngo ? $ngo->id : null,
            'new_membership_id' => $newMembership ? $newMembership->id : null,
            'membership_id' => $oldMembership ? $oldMembership->id : null,
        ]);



        return redirect()->route('registrations.thank', $event->id)
            ->with('success', 'You have registered successfully!');
    }

    // Admin view: list registrations
    public function index()
    {
        // Get only the last finished event
        $events = Event::with('registrations')
            ->orderBy('end_date', 'desc')
            ->get();

        return view('registrations.index', compact('events'));
    }


    public function show($eventId)
    {
        $event = Event::with('registrations')->findOrFail($eventId);
        $registrations = $event->registrations;

        return view('registrations.showAll', compact('event', 'registrations'));
    }


    public function thankYou()
    {
        return view('registrations.thank');
    }

}
