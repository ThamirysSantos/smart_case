<?php

declare(strict_types=1);

namespace App\Util;

class RateCalculator
{
    const PIX_FEE_RATE = 0.015;
    const BOLETO_FEE_RATE = 0.02;
    const BANK_TRANSFER_FEE_RATE = 0.04;

    public function execute(float $amount, string $paymentMethod): float
    {
        return $amount * match ($paymentMethod) {
            'pix' => self::PIX_FEE_RATE,
            'boleto' => self::BOLETO_FEE_RATE,
            'bank-transfer' => self::BANK_TRANSFER_FEE_RATE,
            default => 0
        };
    }
}
