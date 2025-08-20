<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'name', 'email', 'phone'
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_participant')
                    ->withPivot('present', 'qr_code')
                    ->withTimestamps();
    }
}
