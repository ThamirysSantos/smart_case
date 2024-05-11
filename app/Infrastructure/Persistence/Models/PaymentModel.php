<?php

namespace Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'name_client',
        'cpf',
        'description',
        'amount',
        'status',
        'payment_method',
        'paid_at',
    ];
}