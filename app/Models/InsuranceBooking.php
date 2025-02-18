<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceBooking extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id', 'insurance_id'];

    public function booking()
    {
        return $this->belongsTo(TripBooking::class);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }
}
