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
        public int $merchant_id = 0,
        public string $name = '',
        public string $cpf = '',
        public string $description = '',
        public float $amount = 0,
        public string $payment_method = '',
    ){
        $this->status = StatusEnum::PENDING;
        $this->paid_at = null;
    }

    public function toArray()
    {
        return [
            'merchant_id' => $this->merchant_id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'description' => $this->description,
            'amount' => $this->amount,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'paid_at' =>$this->paid_at,
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
    }
}

