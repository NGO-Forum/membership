<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;


Route::get('/calendar', [CalendarController::class, 'api']);
Route::post('/events/send-email', [CalendarController::class, 'sendEmail']);

