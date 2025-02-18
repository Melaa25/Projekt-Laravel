<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternetPackage extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'data_limit', 'price'];

    public function bookings()
    {
        return $this->hasMany(InternetPackageBooking::class);
    }
    public function tripBookings()
    {
        return $this->belongsToMany(TripBooking::class, 'internet_package_bookings', 'internet_package_id', 'booking_id');
    }
    

}
