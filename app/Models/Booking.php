<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'date', 'total_price', 'start_time', 'end_time', 'staff_id','client_id','status'];

     protected $appends = ['display_name'];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class); 
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_bookings');
    }
    
    
    public function getDisplayNameAttribute()
    {
        if ($this->client) {
            return $this->client->name;
        }

        return trim(
            ($this->user?->first_name ?? 'N/A') . ' ' .
            ($this->user?->last_name ?? '')
        );
    }

    
    public function getDisplayInitialAttribute()
    {
        return strtoupper(substr($this->display_name, 0, 1));
    }

}
