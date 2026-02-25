<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Specify the table associated with the model (optional, if not plural)
    protected $table = 'services';

    // Specify the fillable attributes
    protected $fillable = [
        'name',
        'price',
        'color',
        'description',
        'gender',
        'category_id',
        'service_image',
    ];

    // Specify the attributes that should be cast to native types
    protected $casts = [
        'price' => 'decimal:2', // Cast to decimal with 2 decimal points
        'percentage' => 'decimal:2', // Cast to decimal with 2 decimal points
    ];


    // Define the relationship to category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
