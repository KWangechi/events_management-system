<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'organization_id',
        'title',
        'description',
        'venue',
        'date',
        'price',
        'max_attendees'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
        'price' => 'decimal:2',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \App\Models\Scopes\OrganizationScope);
    }

    /**
     * Get the organization that owns the event.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the attendees for the event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Attendee>
     */
    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }
}
