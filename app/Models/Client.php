<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Define fillable fields
    protected $fillable = [
        'name',
        'email',
        'contact',
        'address',
        'whatsapp',
        'allergies'
    ];

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
