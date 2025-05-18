<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\Request;

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
        return response()->json($events);
    }


    public function index()
    {
        $events = $this->eventService->getEvents();
        return response()->json($events);
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

        $data['organization_id'] = $this->eventService->createEvent($data)->id;

        $createdEvent = $this->eventService->createEvent($data);
        return $this->successResponse($createdEvent, 'Event Created!', 201);
    }
}
