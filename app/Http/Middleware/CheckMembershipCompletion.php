<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Membership;

class CheckMembershipCompletion
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Check if membership form already completed
        $membership = Membership::where('user_id', $user->id)->first();

        if ($membership) {
            return redirect()->route('membership.thankyou');
        }

        return $next($request);
    }
}
