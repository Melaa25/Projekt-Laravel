<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'price', 'category_id', 'guide_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function bookings()
    {
        return $this->hasMany(TripBooking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
