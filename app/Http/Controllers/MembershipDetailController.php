<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipDetailController extends Controller
{
    public function index()
    {
        return view('membership.membershipDetail');
    }
}
