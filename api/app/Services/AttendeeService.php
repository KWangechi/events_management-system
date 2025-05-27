<?php

namespace App\Services;

use App\Models\Attendee;
use App\Repositories\AttendeeRepository;
use App\Repositories\EventRepository;
use Illuminate\Support\Facades\Auth;
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

        return $this->attendeeRepository->create($data, $eventId);
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
        $data['user_id'] = Auth::id();

        return $this->attendeeRepository->create($data, $eventId);
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

    public function detachAttendeeEvent($eventId)
    {
        $userId = Auth::id();

        $this->eventExists($eventId);

        $attendee = Attendee::where('user_id', $userId)
            ->first();

        // dd($attendee);
        return $attendee->events()->detach($eventId);
    }
}
