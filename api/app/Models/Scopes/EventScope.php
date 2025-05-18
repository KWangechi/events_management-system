<?php

namespace App\Models\Scopes;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Symfony\Component\HttpFoundation\Response;

class EventScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {

        if (request()->route('eventId')) {
            $event = Event::where('id', request()->route('eventId'))->first();
            if ($event) {
                $builder->where('event_id', $event->id);
            } else {
                abort(Response::HTTP_NOT_FOUND, 'Event not found');
            }
        }
    }
}
