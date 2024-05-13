<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Payment;

class GetPayment
{
    public int $merchantId;
    public string $paymentId;

    public function __construct(
        int $merchantId = 0,
        string $paymentId = '',
    ){
        $this->merchantId = $merchantId;
        $this->paymentId = $paymentId;
    }
}    
