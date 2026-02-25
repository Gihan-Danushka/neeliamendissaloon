<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_number',
        'ratings',
        'experience',
        'join_date',
        'bank_account_number',
        'bank_name',
        'basic_salary',
        'etf_number'
    ];


   public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_staff');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
