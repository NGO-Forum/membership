<?php

namespace App\Http\Controllers;

use App\Models\NewMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewMembershipController extends Controller
{
    public function form()
    {
        return view('membership.membershipForm');
    }

    public function storeForm(Request $request)
    {
        $request->validate([
            'org_name_en' => 'required|string|max:255',
            'org_name_kh' => 'required|string|max:255',
            'org_name_abbreviation' => 'required|string|max:255',

            'address' => 'nullable|string|max:1000',
            'alt_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',

            'membership_type' => 'required|in:Full member,Associate member',

            'director_name' => 'required|string|max:255',
            'director_email' => 'required|email',
            'director_phone' => 'required|string|max:20',

            'representative_name' => 'required|string|max:255',
            'representative_email' => 'required|email',
            'representative_phone' => 'required|string|max:20',
            'representative_position' => 'required|string|max:100',


        ]);

        NewMembership::create(array_merge(
            $request->all(),
            ['user_id' => Auth::id()]  // ← add this
        ));
        return redirect()->route('membership.membershipUpload');
    }

    public function edit($id)
    {
        $membership = NewMembership::findOrFail($id);

        return view('admin.editNewMembership', compact('membership'));
    }

    public function newUpdate(Request $request, $id)
    {
        $membership = NewMembership::findOrFail($id);

        // Validation
        $validated = $request->validate([
            'ngo_name_en' => 'required|string|max:255',
            'ngo_name_kh' => 'required|string|max:255',
            'org_name_abbreviation' => 'required|string|max:255',

            'director_name' => 'required|string|max:255',
            'director_email' => 'required|email',

            'address' => 'nullable|string|max:1000',
            'alt_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',

            'membership_type' => 'required|in:Full member,Associate member',

            'director_phone' => 'required|string|max:20',

            'representative_name' => 'required|string|max:255',
            'representative_email' => 'required|email',
            'representative_phone' => 'required|string|max:20',
            'representative_position' => 'required|string|max:100',
        ]);

        $membership->update($validated);

        return redirect()->route('admin.newMembership');
    }

    public function delete($id)
    {
        $membership = NewMembership::findOrFail($id);
        $membership->delete();

        return redirect()->route('admin.newMembership')
            ->with('success', 'Membership deleted successfully.');
    }
}
