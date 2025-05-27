<?php

namespace App\Repositories;

use App\Models\Attendee;

class AttendeeRepository
{
    public function create(array $data, $eventId)
    {
        $attendee = Attendee::firstOrCreate($data);
        $attendee->events()->syncWithoutDetaching($eventId);
        return $attendee;
    }
    public function update($id, array $data)
    {
        $attendee = $this->find($id);
        $attendee->update($data);
        return $attendee;
    }
    public function delete($id)
    {
        $attendee = $this->find($id);
        $attendee->delete();
        return $attendee;
    }
    public function all()
    {
        return Attendee::all();
    }
    public function findByEvent($eventId)
    {
        return Attendee::where('event_id', $eventId)->get();
    }

    public function find($id)
    {
        return Attendee::find($id);
    }

    public function countByEventId($eventId)
    {
        return Attendee::where('event_id', $eventId)->count();
    }
}
