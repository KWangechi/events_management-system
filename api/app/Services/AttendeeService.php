<?php

namespace App\Services;

use App\Repositories\AttendeeRepository;
use App\Repositories\EventRepository;

class AttendeeService
{
    protected $attendeeRepository;
    protected $eventRepository;

    public function __construct(AttendeeRepository $attendeeRepository, EventRepository $eventRepository)
    {
        $this->attendeeRepository = $attendeeRepository;
        $this->eventRepository = $eventRepository;
    }

    public function register(array $data)
    {

        $eventId = $data['event_id'];
        $event = $this->eventRepository->find($eventId);

        // Check if event exists
        if (!$event) {
            throw new \Exception('Event not found.');
        }

        // Check if max attendees limit is set and not reached
        if ($this->isRegistrationClosed($event)) {
            throw new \Exception('Registration closed: maximum number of attendees reached.');
        }

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
}
