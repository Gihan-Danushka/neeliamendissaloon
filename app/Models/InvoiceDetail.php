<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'color',
        'colorCode',
        'percentage',
        'reminding_date',
        'invoice_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
