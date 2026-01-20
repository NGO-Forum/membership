<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminSystemController extends Controller
{
    // List all admins with roles: admin, ed, board, operations
    public function index()
    {
        $roles = ['admin', 'ed', 'board', 'operations', 'manager'];
        $admins = User::whereIn('role', $roles)->get();

        return view('admins.index', compact('admins'));
    }

    // Show create form
    public function create()
    {
        return view('admins.create');
    }

    // Store new admin
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'ngo' => 'required|string|max:255',
            'role' => 'required|in:admin,ed,board,operations',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // validate image
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'ngo' => $request->ngo,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('admins', 'public');
        }

        User::create($data);

        return redirect()->route('admins.index');
    }

    // Show edit form
    public function edit(User $admin)
    {
        return view('admins.edit', compact('admin'));
    }

    // Update admin
    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'ngo' => 'required|string|max:255',
            'role' => 'required|in:admin,ed,board,operations',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'ngo' => $request->ngo,
            'role' => $request->role,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($admin->image && Storage::disk('public')->exists($admin->image)) {
                Storage::disk('public')->delete($admin->image);
            }
            $data['image'] = $request->file('image')->store('admins', 'public');
        }

        $admin->update($data);

        return redirect()->route('admins.index');
    }

    // Delete admin
    public function destroy(User $admin)
    {
        // Delete image if exists
        if ($admin->image && Storage::disk('public')->exists($admin->image)) {
            Storage::disk('public')->delete($admin->image);
        }

        $admin->delete();

        return redirect()->route('admins.index');
    }
}
