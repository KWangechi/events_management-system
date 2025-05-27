<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationController;
use App\Http\Middleware\EnsureOrganizationAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// ------------------- PUBLIC ROUTES -------------------
// View all events (across all organizations)
Route::get('all-events', [EventController::class, 'getAllEvents'])->name('events.getAllEvents');

// View events for a specific organization
Route::get('/{organization}/events', [EventController::class, 'index'])->name('events.index');
Route::get('/{organization}/events/{event}', [EventController::class, 'show'])->name('events.show');

// Public attendee registration for an event
Route::post('/{organization}/events/{event}/attendees', [AttendeeController::class, 'register'])->name('attendees.register');

// ------------------- AUTH ROUTES -------------------
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->middleware('auth:sanctum')->name('logout');
});

// ------------------- SUPER ADMIN ROUTES -------------------
// Only super admins can create organizations
Route::middleware(['auth:sanctum', 'can:isSuperAdmin'])->group(function () {
    Route::post('/organizations', [OrganizationController::class, 'store'])->name('organizations.store');
    Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
});

// ------------------- ORGANIZATION ADMIN ROUTES -------------------
// Organization admins manage their own org's data
Route::middleware('auth:sanctum')->prefix('/admin/{organization:slug}')->group(function () {
    // Organization details
    Route::get('/', [OrganizationController::class, 'show'])->name('admin.organizations.show');
    Route::post('/', [OrganizationController::class, 'store'])->name('admin.organizations.store');
    Route::put('/', [OrganizationController::class, 'update'])->name('admin.organizations.update');
    Route::delete('/', [OrganizationController::class, 'destroy'])->name('admin.organizations.destroy');


    // Events management
    Route::middleware([EnsureOrganizationAdmin::class])->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
        Route::post('events', [EventController::class, 'store'])->name('admin.events.store');
        Route::get('events/{eventId}', [EventController::class, 'show'])->name('admin.events.show');
        Route::patch('events/{eventId}', [EventController::class, 'update'])->name('admin.events.update');
        Route::delete('events/{eventId}', [EventController::class, 'destroy'])->name('admin.events.destroy');

        // Attendees management (nested under events)
        Route::get('events/{eventId}/attendees', [AttendeeController::class, 'index'])->name('admin.attendees.index');
        Route::post('events/{eventId}/attendees', [AttendeeController::class, 'store'])->name('admin.attendees.store');
        Route::get('events/{eventId}/attendees/{attendeeId}', [AttendeeController::class, 'show'])->name('admin.attendees.show');
        Route::patch('events/{eventId}/attendees/{attendeeId}', [AttendeeController::class, 'update'])->name('admin.attendees.update');
        Route::delete('events/{eventId}/attendees/{attendeeId}', [AttendeeController::class, 'destroy'])->name('admin.attendees.destroy');
    });
});


