<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = [
        'user_id',
        'company',
        'contact_person',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'country',
        'notes',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
