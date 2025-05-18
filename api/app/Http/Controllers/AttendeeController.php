<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organization;
use App\Services\AttendeeService;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    protected $attendeeService;

    public function __construct(AttendeeService $attendeeService)
    {
        $this->attendeeService = $attendeeService;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $attendee = $this->attendeeService->register($data);
        return $this->successResponse($attendee, 'Registration successful', 201);
    }
}
