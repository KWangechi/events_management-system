<?php

namespace App\Services;

use App\Repositories\EventRepository;

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
        return $this->eventRepository->create($data);
    }
    public function updateEvent($id, array $data)
    {
        return $this->eventRepository->update($id, $data);
    }
    public function deleteEvent($id)
    {
        return $this->eventRepository->delete($id);
    }
    public function getEvent($id)
    {
        return $this->eventRepository->find($id);
    }
    // public function getEventsByOrganization($organizationId)
    // {
    //     return $this->eventRepository->findByOrganization($organizationId);
    // }
}
