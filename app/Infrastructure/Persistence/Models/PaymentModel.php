<?php

namespace App\Infrastructure\Persistence\Models;

use App\Util\StatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'payment';

    protected $fillable = [
        'merchant_id',
        'name',
        'cpf',
        'description',
        'amount',
        'status',
        'payment_method',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'status' => StatusEnum::class
        ];
    }
}
