<?php

namespace App\Http\Controllers;

use App\Models\NewMembership;

class HomeController extends Controller
{
    public function index()
    {
        $currentYear = now()->year; // auto year

        // approved members in current year only
        $membersCount = NewMembership::where('status', 'approved')
            ->whereYear('created_at', $currentYear)
            ->count();
        return view('/home', compact('membersCount', 'currentYear'));
    }
}
