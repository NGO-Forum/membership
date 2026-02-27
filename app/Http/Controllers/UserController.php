<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewMembership;
use App\Models\Registration;

class UserController extends Controller
{

    public function newProfile()
    {
        $memberships = NewMembership::with([
            'user',
            'membershipUploads.networks',
            'membershipUploads.focalPoints'
        ])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('users.newProfile', compact('memberships'));
    }

    public function report()
    {
        $userId = auth()->id();
        $newMembershipIds = NewMembership::where('user_id', $userId)->pluck('id')->toArray();

        $registrations = Registration::with('event')
            ->orWhereIn('new_membership_id', $newMembershipIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reports.eventReport', compact('registrations'));
    }
}
