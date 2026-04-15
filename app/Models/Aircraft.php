<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    protected $table = 'aircraft';

    protected $fillable = [
        'name'
    ];

    public $timestamps = true;

    // protected $casts = [
    //     'created_at'  => 'date:Y-m-d H:i:s',
    //     'updated_at' => 'date:Y-m-d H:i:s'
    // ];
}
