<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function getAllEvents()
    {
        $events = $this->eventService->getAllEvents();
        return $this->successResponse($events, 'Events retrieved successfully');
    }


    public function index()
    {
        $events = $this->eventService->getEvents();
        return $this->successResponse($events, 'Events retrieved successfully');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'venue' => 'required|string',
            'date' => 'required|date',
            'price' => 'required|numeric',
            'max_attendees' => 'required|integer',
        ]);


        $createdEvent = $this->eventService->createEvent($data);
        return $this->successResponse($createdEvent, 'Event Created!', Response::HTTP_CREATED);
    }

    public function show($orgSlug, $id)
    {
        $event = $this->eventService->getEvent($id);
        return $this->successResponse($event, 'Event retrieved successfully');
    }

    public function update(Request $request, $orgSlug, $id)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'venue' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
            'price' => 'sometimes|required|numeric',
            'max_attendees' => 'sometimes|required|integer',
        ]);

        $updatedEvent = $this->eventService->updateEvent($orgSlug, $id, $data);
        return $this->successResponse($updatedEvent, 'Event updated successfully');
    }

    public function destroy($orgSlug, $id)
    {
        $this->eventService->deleteEvent($orgSlug, $id);
        return $this->successResponse(null, 'Event deleted successfully');
    }
}
