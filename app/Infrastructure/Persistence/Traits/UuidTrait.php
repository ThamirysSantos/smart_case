<?php
namespace App\Infrastructure\Persistence\Traits;
use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    public static function bootUuid()
    {
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4();
        });
    }
}
