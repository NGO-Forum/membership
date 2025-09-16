<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\FileViewController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\MembershipDetailController;
use App\Http\Controllers\NewMembershipController;
use App\Http\Controllers\MembershipUploadController;
use App\Http\Controllers\MembershipReportController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RegistrationController;


// Authentication routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', [homeController::class, 'index'])->name('home');

// Public Event Registration (no auth required)
Route::get('/events/{event}/register', [RegistrationController::class, 'create'])->name('events.register');
Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register.store');
Route::get('/registrations/thank', [RegistrationController::class, 'thankYou'])->name('registrations.thank');

// Optional: direct QR preview
Route::get('/events/qr', [EventController::class, 'register'])->name('events.qr');

Route::middleware(['auth'])->group(function () {

    // Admin routes (just examples)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('user');
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/membership', [AdminController::class, 'membershipShow'])->name('membership');
        Route::get('/newMembership', [AdminController::class, 'newMembership'])->name('newMembership');
    });

    //edit and delete old memberships
    Route::get('/memberships/{id}/edit', [MembershipController::class, 'edit'])->name('admin.edit');
    Route::put('/memberships/{id}', [MembershipController::class, 'update'])->name('admin.update');
    Route::delete('/memberships/{id}', [MembershipController::class, 'destroy'])->name('admin.destroy');


    //edit and delete New Memberships
    Route::get('/newMemberships/{id}/edit', [NewMembershipController::class, 'edit'])->name('admin.editNewMembership');
    Route::put('/newMemberships/{id}', [NewMembershipController::class, 'newUpdate'])->name('admin.newUpdate');
    Route::delete('/newMemberships/{id}', [NewMembershipController::class, 'delete'])->name('admin.delete');

    // User profile routes
    Route::get('/profile', [UserController::class, 'profile'])
        ->name('profile');
    Route::get('/newProfile', [UserController::class, 'newProfile'])
        ->name('newProfile');


    // Membership main form routes
    Route::get('/membership/form', [MembershipController::class, 'showForm'])->name('membership.form');
    Route::post('/membership/form', [MembershipController::class, 'submitReconfirmation'])->name('membership.submit');

    // Membership application upload routes
    Route::get('/membership/formUpload', [MembershipApplicationController::class, 'showForm'])->name('membership.formUpload');
    Route::post('/membership/formUpload', [MembershipApplicationController::class, 'submit'])->name('membership.submitUpload');
    Route::get('/membership/formUpload/{id}', [MembershipApplicationController::class, 'showForm'])->name('membership.formUpload.id');

    // Membership reconfirmation routes (if different from main form)
    Route::get('/membership/reconfirm', [MembershipController::class, 'showFormReconfirm'])->name('membership.reconfirm.form');
    Route::post('/membership/reconfirm', [MembershipController::class, 'submitReconfirmation'])->name('membership.reconfirm.submit');

    // Thank you page
    Route::get('/membership/thankyou', [MembershipController::class, 'thankyou'])->name('membership.thankyou');

    // Membership management routes
    Route::get('/admin/show/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/admin/newShowMembership/{id}', [AdminController::class, 'newShowMembership'])
        ->name('admin.newShowMembership');


    // Membership export routes
    Route::get('/admin/export/excel', [MembershipController::class, 'exportExcel'])->name('memberships.exportExcel');
    Route::get('/admin/export/pdf', [MembershipController::class, 'exportPDF'])->name('memberships.exportPDF');
    Route::get('/admin/export/word', [MembershipController::class, 'exportWord'])->name('memberships.exportWord');
    Route::get('/file-view/{path}', [FileViewController::class, 'viewFile'])
        ->where('path', '.*')
        ->name('file.view');

    // Membership detail route
    Route::get('/membership/menbershipDetail', [MembershipDetailController::class, 'index'])->name('membership.menbershipDetail');

    // New Membership form routes
    Route::get('/membership/membershipForm', [NewMembershipController::class, 'form'])->name('membership.membershipForm');
    Route::post('/membership/membershipForm', [NewMembershipController::class, 'storeForm'])->name('memberships.storeForm');

    // New Membership form Upload
    Route::get('/membership/membershipUpload', [MembershipUploadController::class, 'form'])->name('membership.membershipUpload');
    Route::post('/membership/membershipUpload', [MembershipUploadController::class, 'store'])->name('memberships.store');

    //Report Data
    Route::get('/reports/membership', [MembershipReportController::class, 'index'])->name('reports.membership');
    Route::get('/reports/show/{id}', [MembershipReportController::class, 'show'])->name('reports.show');


    // Event calendar routes
    Route::prefix('calendar')->name('events.')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('calendar');   // events.calendar
        Route::post('/', [CalendarController::class, 'store'])->name('store');      // events.store
    });

    // Event management routes
    Route::prefix('newEvent')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('newEvent');   // events.Event
        Route::post('/', [EventController::class, 'store'])->name('store');      // events.store
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit'); // events.edit
        Route::put('/{event}', [EventController::class, 'update'])->name('update'); // events.update
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy'); // events.destroy
        Route::get('/{event}/json', [EventController::class, 'getEvent'])->name('json');
    });

    // Past events route
    Route::get('/events/pastEvent', [EventController::class, 'showPast'])->name('events.pastEvent');

    Route::get('/events/{event}/download-qr', [EventController::class, 'downloadQr'])->name('events.downloadQr');

    // Admin view of attendees
    Route::get('/registrations/index', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{eventId}', [RegistrationController::class, 'show'])->name('registrations.showAll');

    // Event files upload
    Route::post('/events/{event}/files', [EventController::class, 'addFiles'])->name('events.addFiles');
    Route::post('/events/{event}/images', [EventController::class, 'addImages'])->name('events.addImages');

    // User view of upcoming events
    Route::get('/events/userEvent', [EventController::class, 'newEvent'])->name('events.userEvent');
    Route::get('/reports/eventReport', [UserController::class, 'report'])->name('reports.eventReport');

    Route::post('/send-email', [EventController::class, 'sendEmail'])->name('send.email');

});
