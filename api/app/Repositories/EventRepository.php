<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventRepository
{
    public function all()
    {
        return DB::table('events')->get();
    }

    public function getEvents()
    {
        return Event::all();
    }

    public function create(array $data)
    {
        return Event::create($data);
    }

    public function find($id)
    {
        return Event::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $event = $this->find($id);
        $event->update($data);
        return $event;
    }
    public function delete($id)
    {
        $event = $this->find($id);
        $event->delete();
        return $event;
    }

    public function findByOrganization($organizationId)
    {
        return Event::where('organization_id', $organizationId)->get();
    }
}
