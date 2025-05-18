<?php

namespace App\Services;

use App\Repositories\AttendeeRepository;
use App\Repositories\EventRepository;
use Symfony\Component\HttpFoundation\Response;

class AttendeeService
{
    protected $attendeeRepository;
    protected $eventRepository;

    public function __construct(AttendeeRepository $attendeeRepository, EventRepository $eventRepository)
    {
        $this->attendeeRepository = $attendeeRepository;
        $this->eventRepository = $eventRepository;
    }

    public function getAll()
    {
        return $this->attendeeRepository->all();
    }

    public function create($orgSlug, $eventId, array $data)
    {

        $this->eventExists($eventId);

        $data['event_id'] = $eventId;
        return $this->attendeeRepository->create($data);
    }


    public function update($orgSlug, $eventId, $id, array $data)
    {
        $this->eventExists($eventId);
        $this->getById($id);
        return $this->attendeeRepository->update($id, $data);
    }


    public function delete($orgSlug, $eventId, $id)
    {
        $this->eventExists($eventId);
        $this->getById($id);
        return $this->attendeeRepository->delete($id);
    }


    public function register($orgSlug, $eventId, array $data)
    {
        $data['event_id'] = $eventId;
        return $this->attendeeRepository->create($data);
    }

    public function isRegistrationClosed($event)
    {
        // Check if the event has a maximum number of attendees set
        if ($event->max_attendees) {
            $currentAttendeeCount = $this->attendeeRepository->countByEventId($event->id);
            return $currentAttendeeCount >= $event->max_attendees;
        }
        return false;
    }


    public function eventExists($eventId)
    {
        $event = $this->eventRepository->find($eventId);

        if (!$event) {
            abort(Response::HTTP_NOT_FOUND, 'Event not found');
        }
        return $event;
    }

    public function getById($id)
    {
        // Check if the event exists
        $attendee = $this->attendeeRepository->find($id);
        if (!$attendee) {
            abort(Response::HTTP_NOT_FOUND, 'Attendee not found');
        }
        return $attendee;
    }
}
