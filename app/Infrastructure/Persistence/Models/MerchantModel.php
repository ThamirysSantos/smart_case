<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MerchantModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "merchant";

    protected $fillable = [
        'name',
        'email',
        'password',
        'amount',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
