<?php

declare(strict_types=1);

namespace App\Domain\Dtos;

class Merchant
{
    public string $name;
    public string $email;
    public int $amount;

    public function __construct(string $name, string $email, int $amount)
    {
        $this->name = $name;
        $this->email = $email;
        $this->amount = $amount;
    }
}    
