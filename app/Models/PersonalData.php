<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'address', 'city', 'postal_code', 'phone', 'birth_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
