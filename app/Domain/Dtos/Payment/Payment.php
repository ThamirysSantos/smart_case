<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Payment;

class Payment
{
    public ?int $merchantId;
    public string $nameClient;
    public string $cpf;
    public string $description;
    public int $amount;
    public string $status;
    public string $paymentMethod;
    public string $paidAt;

    public function __construct(
        int $merchantId = 0,
        string $nameClient = '',
        string $cpf = '',
        string $description = '',
        int $amount = 0,
        string $paymentMethod = '',
        ?string $paidAt = '',
    ){
        $this->merchantId = $merchantId;
        $this->nameClient = $nameClient;
        $this->cpf = $cpf;
        $this->description = $description;
        $this->amount = $amount;
        $this->status = 'PENDING';
        $this->paymentMethod = $paymentMethod;
        $this->paidAt = $paidAt;
    }

    public function toArray()
    {
        return [
            'merchantId' => $this->merchantId,
            'nameClient' => $this->nameClient,
            'cpf' => $this->cpf,
            'description' => $this->description,
            'amount' => $this->amount,
            'status' => $this->status,
            'paymentMethod' => $this->paymentMethod,
            'paidAt' =>$this->paidAt,
        ];
    }

    public function setPaidAt(string $paidAt): void
    {
        $this->paidAt = $paidAt;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}    
