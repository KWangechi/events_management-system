<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationController;
use App\Http\Middleware\EnsureOrganizationAdmin;
use Illuminate\Support\Facades\Route;

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
    // Add more super admin routes here if needed
});

// ------------------- ORGANIZATION ADMIN ROUTES -------------------
// Organization admins manage their own org's data
Route::middleware('auth:sanctum')->prefix('/{organization:slug}')->group(function () {
    // Organization details
    Route::get('/', [OrganizationController::class, 'show'])->name('organizations.show');
    Route::post('/', [OrganizationController::class, 'store'])->name('organizations.store');
    Route::put('/', [OrganizationController::class, 'update'])->name('organizations.update');
    Route::delete('/', [OrganizationController::class, 'destroy'])->name('organizations.destroy');


    // Events management
    Route::middleware([EnsureOrganizationAdmin::class])->group(function () {
        Route::get('events', [EventController::class, 'index'])->name('events.index');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::get('events/{eventId}', [EventController::class, 'show'])->name('events.show');
        Route::patch('events/{eventId}', [EventController::class, 'update'])->name('events.update');
        Route::delete('events/{eventId}', [EventController::class, 'destroy'])->name('events.destroy');

        // Attendees management (nested under events)
        Route::get('events/{eventId}/attendees', [AttendeeController::class, 'index'])->name('attendees.index');
        Route::post('events/{eventId}/attendees', [AttendeeController::class, 'store'])->name('attendees.store');
        Route::get('events/{eventId}/attendees/{attendeeId}', [AttendeeController::class, 'show'])->name('attendees.show');
        Route::patch('events/{eventId}/attendees/{attendeeId}', [AttendeeController::class, 'update'])->name('attendees.update');
        Route::delete('events/{eventId}/attendees/{attendeeId}', [AttendeeController::class, 'destroy'])->name('attendees.destroy');
    });
});

// ------------------- PUBLIC ROUTES -------------------
// View all events (across all organizations)
Route::get('/events', [EventController::class, 'getAllEvents'])->name('events.getAllEvents');

// View events for a specific organization
Route::get('/{organization}/events', [EventController::class, 'index'])->name('events.index');
Route::get('/{organization}/events/{event}', [EventController::class, 'show'])->name('events.show');

// Public attendee registration for an event
Route::post('/{organization}/events/{event}/attendees', [AttendeeController::class, 'register'])->name('attendees.register');
