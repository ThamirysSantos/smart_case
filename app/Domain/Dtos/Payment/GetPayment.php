<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Payment;

class GetPayment
{
    public function __construct(
        public int $merchantId = 0,
        public string $paymentId = '',
    ){}
}    
