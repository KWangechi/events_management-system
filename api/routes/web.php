<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    // return view('welcome');
    return response()->json(['message' => 'Welcome to the Event Management API']);
});
