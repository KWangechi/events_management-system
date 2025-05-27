<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventRepository
{
    public function all()
    {
        return DB::table('events')
            ->join('organizations', 'events.organization_id', '=', 'organizations.id')
            ->select('events.*', 'organizations.slug as organization_slug', 'organizations.name as organization_name')
            ->get();
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
        return Event::find($id);
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
        return null;
    }

    public function findByOrganization($organizationId)
    {
        return Event::where('organization_id', $organizationId)->get();
    }
}
