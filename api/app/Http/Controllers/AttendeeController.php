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

    public function index()
    {
        $attendees = $this->attendeeService->getAll();
        return $this->successResponse($attendees, 'Attendees retrieved successfully');
    }

    public function show($orgSlug, $eventId, $id)
    {
        $attendee = $this->attendeeService->getById($id);
        return $this->successResponse($attendee, 'Attendee retrieved successfully');
    }

    public function store(Request $request, $orgSlug, $eventId)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $attendee = $this->attendeeService->create($orgSlug, $eventId, $data);
        return $this->successResponse($attendee, 'Attendee created successfully', 201);
    }

    public function update(Request $request, $orgSlug, $eventId, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'phone' => 'sometimes|required|string',
        ]);

        $attendee = $this->attendeeService->update($orgSlug, $eventId, $id, $data);
        return $this->successResponse($attendee, 'Attendee updated successfully');
    }

    public function destroy($orgSlug, $eventId, $id)
    {
        $deleted = $this->attendeeService->delete($orgSlug, $eventId, $id);
        if (!$deleted) {
            return $this->errorResponse('Attendee not found', 404);
        }
        return $this->successResponse(null, 'Attendee deleted successfully');
    }

    public function register(Request $request, $orgSlug, $eventId)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $attendee = $this->attendeeService->register($orgSlug, $eventId, $data);
        return $this->successResponse($attendee, 'Registration successful', 201);
    }
}
