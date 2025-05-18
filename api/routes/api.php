<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // event routes
    Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
    Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
    Route::put('/events/{event}', [\App\Http\Controllers\EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');

    // attendee routes
    Route::get('/events/{event}/attendees', [\App\Http\Controllers\AttendeeController::class, 'index'])->name('attendees.index');
    Route::get('/events/{event}/attendees/{attendee}', [\App\Http\Controllers\AttendeeController::class, 'show'])->name('attendees.show');
    Route::post('/events/{event}/attendees', [\App\Http\Controllers\AttendeeController::class, 'store'])->name('attendees.store');
    Route::put('/events/{event}/attendees/{attendee}', [\App\Http\Controllers\AttendeeController::class, 'update'])->name('attendees.update');
    Route::delete('/events/{event}/attendees/{attendee}', [\App\Http\Controllers\AttendeeController::class, 'destroy'])->name('attendees.destroy');

    // organization routes
    // Route::get('/organizations', [\App\Http\Controllers\OrganizationController::class, 'index'])->name('organizations.index');
    // Route::get('/organizations/{organization}', [\App\Http\Controllers\OrganizationController::class, 'show'])->name('organizations.show');
    // Route::post('/organizations', [\App\Http\Controllers\OrganizationController::class, 'store'])->name('organizations.store');
    // Route::put('/organizations/{organization}', [\App\Http\Controllers\OrganizationController::class, 'update'])->name('organizations.update');
    // Route::delete('/organizations/{organization}', [\App\Http\Controllers\OrganizationController::class, 'destroy'])->name('organizations.destroy');
    // // organization user routes
    // Route::get('/organizations/{organization}/users', [\App\Http\Controllers\OrganizationUserController::class, 'index'])->name('organizations.users.index');
    // Route::get('/organizations/{organization}/users/{user}', [\App\Http\Controllers\OrganizationUserController::class, 'show'])->name('organizations.users.show');
    // Route::post('/organizations/{organization}/users', [\App\Http\Controllers\OrganizationUserController::class, 'store'])->name('organizations.users.store');
    // Route::put('/organizations/{organization}/users/{user}', [\App\Http\Controllers\OrganizationUserController::class, 'update'])->name('organizations.users.update');
    // Route::delete('/organizations/{organization}/users/{user}', [\App\Http\Controllers\OrganizationUserController::class, 'destroy'])->name('organizations.users.destroy');
    // // organization event routes
    // Route::get('/organizations/{organization}/events', [\App\Http\Controllers\OrganizationEventController::class, 'index'])->name('organizations.events.index');
    // Route::get('/organizations/{organization}/events/{event}', [\App\Http\Controllers\OrganizationEventController::class, 'show'])->name('organizations.events.show');
    // Route::post('/organizations/{organization}/events', [\App\Http\Controllers\OrganizationEventController::class, 'store'])->name('organizations.events.store');
    // Route::put('/organizations/{organization}/events/{event}', [\App\Http\Controllers\OrganizationEventController::class, 'update'])->name('organizations.events.update');
    // Route::delete('/organizations/{organization}/events/{event}', [\App\Http\Controllers\OrganizationEventController::class, 'destroy'])->name('organizations.events.destroy');
    // // organization attendee routes
    // Route::get('/organizations/{organization}/attendees', [\App\Http\Controllers\OrganizationAttendeeController::class, 'index'])->name('organizations.attendees.index');
    // Route::get('/organizations/{organization}/attendees/{attendee}', [\App\Http\Controllers\OrganizationAttendeeController::class, 'show'])->name('organizations.attendees.show');
    // Route::post('/organizations/{organization}/attendees', [\App\Http\Controllers\OrganizationAttendeeController::class, 'store'])->name('organizations.attendees.store');

});
