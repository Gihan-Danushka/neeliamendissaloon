<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total_price',
        'client_id',
        'staff_id',
        'cash_given',
        'balance',
    ];

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
