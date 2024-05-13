<?php

namespace App\Infrastructure\Persistence\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodModel extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'payment_method';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name']
            ]
        ];
    }
}
