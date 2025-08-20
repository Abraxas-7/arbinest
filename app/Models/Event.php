<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'location_id', 
        'start', 'end', 'max_participants', 'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
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
}
