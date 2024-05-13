<?php

declare(strict_types=1);

namespace App\Util;

class RateCalculator
{
    const PIX_FEE_RATE = 0.015; // 1.5%
    const BOLETO_FEE_RATE = 0.02; // 2%
    const TRANSFER_FEE_RATE = 0.04; // 4%

    public function __construct(
        private int $amount,
        private string $paymentMethod,
    ){}

    public function execute(int $amount, string $paymentMethod): int
    {
        switch ($paymentMethod) {
            case 'PIX':
                return $amount * self::PIX_FEE_RATE;
            case 'BOLETO':
                return $amount * self::BOLETO_FEE_RATE;
            case 'BANK_TRANSFER':
                return $amount * self::TRANSFER_FEE_RATE;
            default:
                return 0;
        }
    }
}
