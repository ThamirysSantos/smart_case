<?php

namespace App\Util;

enum StatusEnum: string {
    case PENDING = 'PENDING';
    case PAID = 'PAID';
    case EXPIRED = 'EXPIRED';
    case FAILED = 'FAILED';

    public static function toArray(): array
    {
        return array_column(StatusEnum::cases(), 'value');
    }
}
