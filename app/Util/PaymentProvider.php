<?php

declare(strict_types=1);

namespace App\Util;

class PaymentProvider
{
    public function execute(): bool
    {
        $success = mt_rand(1, 100) <= 70;

        if ($success) {
            return true;
        }
        return false;
    }
}
