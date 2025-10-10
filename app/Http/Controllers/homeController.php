<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
        $membersCount = 70;
        return view('/home', compact('membersCount'));
    }
}
