<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    public function bookings()
    {
        return $this->hasMany(InsuranceBooking::class);
    }
    public function tripBookings()
    {
        return $this->belongsToMany(TripBooking::class, 'insurance_bookings', 'insurance_id', 'booking_id');
    }
    

}
