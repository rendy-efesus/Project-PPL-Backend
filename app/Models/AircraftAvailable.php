<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AircraftAvailable extends Model
{
    protected $table = 'aircraft_available';

    protected $fillable = [
        'aircraft_id',
        'available_start',
        'available_end',
    ];

    public $timestamps = true;

    // relasi ke aircraft
    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class, 'aircraft_id');
    }
}