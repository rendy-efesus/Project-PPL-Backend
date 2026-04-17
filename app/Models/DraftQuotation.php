<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftQuotation extends Model
{
    use HasFactory;

    protected $table = 'draft_quotation';

    protected $fillable = [
        'user_id',
        'customer_id',
        'integrate_id',
        'available_id',
        'flight_type',
        'flight_schedule',
        'flight_route',
        'pax',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION (optional, tapi bagus buat nanti)
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
