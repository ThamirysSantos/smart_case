<?php

declare(strict_types=1);

namespace App\Domain\Dtos;

use Illuminate\Support\Facades\Date;

class Payment
{
    public string $nameClient;
    public string $cpf;
    public string $description;
    public int $amount;
    public string $status;
    public string $payment_method;
    public Date $paidAt;

    public function __construct(string $nameClient, string $cpf, string $description, int $amount, string $status, string $payment_method, Date $paidAt)
    {
        $this->nameClient = $nameClient;
        $this->cpf = $cpf;
        $this->description = $description;
        $this->amount = $amount;
        $this->status = $status;
        $this->payment_method = $payment_method;
        $this->paidAt = $paidAt;
    }
}    
