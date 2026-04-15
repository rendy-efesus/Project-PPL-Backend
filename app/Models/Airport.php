<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $table = 'airport';

    protected $fillable = [
        'code',
        'name',
    ];

    public $timestamps = true;

    // protected $casts = [
    //     'created_at'  => 'date:Y-m-d H:i:s',
    //     'updated_at' => 'date:Y-m-d H:i:s'
    // ];
}
