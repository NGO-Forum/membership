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
            'title' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string',
            'organizer' => 'nullable|string',
        ]);

        Event::create($request->all());
        return redirect()->route('events.calendar')->with('success', 'Event created successfully!');
    }
}
