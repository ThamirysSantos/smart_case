<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Payment;

use App\Util\StatusEnum;
use Carbon\Carbon;

class Payment
{
    public StatusEnum $status;
    public ?Carbon $paid_at;

    public function __construct(
        public int $merchantId = 0,
        public string $name = '',
        public string $cpf = '',
        public string $description = '',
        public float $amount = 0.00,
        public string $payment_method = '',
    ){
        $this->status = StatusEnum::PENDING;
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
            'payment_method' => $this->payment_method,
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
