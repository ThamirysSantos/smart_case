<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodModel extends Model
{
    use HasFactory;

    protected $table = 'payment_method';

    protected $fillable = [
        'name',
        'email',
        'password',
        'amount',
    ];
}
