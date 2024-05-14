<?php

declare(strict_types=1);

namespace App\Util;

class PaymentProvider
{
    public function execute(): bool
    {
        return mt_rand(1, 100) <= 70;
    }
}
