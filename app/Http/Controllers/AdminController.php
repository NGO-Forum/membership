<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipUpload;
use Illuminate\Support\Facades\Auth;
use App\Models\newMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        // Ensure only admin can access these methods
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }
            abort(403, 'Unauthorized access.');
        });
    }

    public function index()
    {
        // Count memberships by status
        $totalNew = NewMembership::where('status', 'approved')->count();
        $totalRequest = NewMembership::where('status', 'pending')->count();
        $totalCancel  = NewMembership::where('status', 'cancel')->count();

        // Old memberships
        $totalOld = Membership::count();

        // Sum all memberships
        $totalMembership = $totalOld + $totalNew;

        $currentMonthNum = Carbon::now()->month; // e.g., 9 for September
        $allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Slice months array up to the current month
        $months = array_slice($allMonths, 0, $currentMonthNum);

        // Get event counts grouped by month up to current month
        $events = DB::table('events')
            ->select(
                DB::raw("MONTH(created_at) as month_num"),
                DB::raw("COUNT(*) as total")
            )
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', '<=', $currentMonthNum)
            ->groupBy('month_num')
            ->pluck('total', 'month_num');

        // Fill missing months with 0
        $monthlyData = [];
        foreach (range(1, $currentMonthNum) as $m) {
            $monthlyData[] = $events[$m] ?? 0;
        }

        $months = $allMonths;

        return view('admin.dashboard', compact(
            'totalNew',
            'totalOld',
            'totalRequest',
            'totalCancel',
            'months',
            'monthlyData',
            'totalMembership'
        ));
    }



    public function membershipShow()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $memberships = Membership::with('user', 'networks', 'focalPoints', 'applications')
            ->where('membership_status', true)  // Only show "Yes"
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.membership', compact('memberships'));
    }

    public function show($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $membership = Membership::with('user', 'networks', 'focalPoints', 'applications', 'registrations')
            ->findOrFail($id);
        if (!$membership->read_at) {
            $membership->update(['read_at' => now()]);
        }

        return view('admin.show', compact('membership'));
    }

    public function newMembership()
    {
        $newMemberships = NewMembership::with([
            'user',
            'membershipUploads.networks',
            'membershipUploads.focalPoints'
        ])->get();

        return view('admin.newMembership', compact('newMemberships'));
    }

    public function newShowMembership($id)
    {
        $membership = NewMembership::with([
            'user',
            'membershipUploads.networks',
            'membershipUploads.focalPoints',
            'registrations.event'
        ])
            ->where('id', $id)
            ->firstOrFail();
        if (!$membership->read_at) {
            $membership->update(['read_at' => now()]);
        }

        return view('admin.newShowMembership', compact('membership'));
    }
}
