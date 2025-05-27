<?php

namespace App\Models;

use App\Models\Scopes\EventScope;
use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'email',
        'phone',
        'registered_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new EventScope);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
