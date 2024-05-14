<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Payment;

use App\Util\StatusEnum;
use Carbon\Carbon;

class Payment
{
    public string $status;
    public ?Carbon $paid_at;

    public function __construct(
        public int $merchantId = 0,
        public string $name = '',
        public string $cpf = '',
        public string $description = '',
        public float $amount = 0.00,
        public string $paymentMethod = '',
    ){
        $this->merchantId = $merchantId;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->description = $description;
        $this->amount = $amount;
        $this->status = StatusEnum::PENDING;
        $this->paymentMethod = $paymentMethod;
        $this->paid_at = null;
    }

    public function toArray()
    {
        return [
            'merchantId' => $this->merchantId,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'description' => $this->description,
            'amount' => $this->amount,
            'status' => $this->status,
            'paymentMethod' => $this->paymentMethod,
            'paidAt' =>$this->paid_at,
        ];
    }

    public function paid(): void
    {
        $this->status = StatusEnum::PAID;
        $this->paid_at = Carbon::now();
    }

    public function failed(): void
    {
        $this->status = StatusEnum::FAILED;
        $this->paid_at = Carbon::now();
    }
}    
