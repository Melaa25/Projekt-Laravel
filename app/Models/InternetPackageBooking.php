<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternetPackageBooking extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id', 'internet_package_id'];

    public function booking()
    {
        return $this->belongsTo(TripBooking::class);
    }

    public function internetPackage()
    {
        return $this->belongsTo(InternetPackage::class, 'package_id');
    }
}
