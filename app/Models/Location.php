<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name', 'address', 'city', 'province', 'zip_code', 'country'
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
