<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Payment;

class PaymentMethod
{
    public string $name;
    public string $slug;

    public function __construct(string $name, string $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }
}    
