<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method \Laravel\Sanctum\NewAccessToken createToken(
 *     string $name,
 *     array $abilities = ['*'],
 *     \DateTimeInterface|null $expiresAt = null
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * Fillable attributes
     */
     protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'role',
        'password',
        'status',
    ];

    /**
     * Hidden attributes (will not be returned in JSON)
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
