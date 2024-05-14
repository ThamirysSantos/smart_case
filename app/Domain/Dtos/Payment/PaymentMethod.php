<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Payment;

class PaymentMethod
{
    public function __construct(
        public string $name,
        public string $slug
    ){
    }
}
