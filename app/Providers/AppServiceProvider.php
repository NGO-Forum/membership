<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\NewMembership;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $myMembership = null;

            if (Auth::check() && Auth::user()->role === 'user') {
                $myMembership = NewMembership::where('user_id', Auth::id())->latest()->first();
            }

            $view->with('myMembership', $myMembership);
        });
    }
}
