<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // Campi massivamente assegnabili
    protected $fillable = [
        'user_id', 'title', 'description', 'location', 'date', 'slug'
    ];


    // Relazioni
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'event_participant')
                    ->withPivot('present', 'qr_code')
                    ->withTimestamps();
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
