<?php

namespace App\Services;

use App\Repositories\EventRepository;
use Illuminate\Support\Facades\Auth;

class EventService
{
    protected $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getAllEvents()
    {
        return $this->eventRepository->all();
    }

    public function getEvents()
    {
        return $this->eventRepository->getEvents();
    }

    public function createEvent(array $data)
    {
        $data['organization_id'] = Auth::user()->organization_id;
        return $this->eventRepository->create($data);
    }
    public function updateEvent($orgSlug, $id, array $data)
    {
        return $this->eventRepository->update($id, $data);
    }
    public function deleteEvent($orgSlug, $id)
    {
        return $this->eventRepository->delete($id);
    }
    public function getEvent($id)
    {
        return $this->eventRepository->find($id);
    }
   
}
