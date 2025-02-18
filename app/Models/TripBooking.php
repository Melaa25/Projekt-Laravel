<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'user_id',
        'booking_date', // Dodaj nową kolumnę
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function insurancePackages()
{
    return $this->belongsToMany(Insurance::class, 'insurance_bookings', 'booking_id', 'insurance_id');
}
public function insurances()
{
    return $this->belongsToMany(Insurance::class, 'insurance_bookings', 'booking_id', 'insurance_id');
}


    public function internetPackages()
    {
        return $this->belongsToMany(InternetPackage::class, 'internet_package_bookings', 'booking_id', 'internet_package_id');
    }
}
