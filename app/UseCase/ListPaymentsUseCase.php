<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Domain\Contracts\PaymentI;

class ListPaymentsUseCase
{
    public function __construct(
        private PaymentI $paymentI,
    ){}

    public function execute(int $merchantId): array
    {   
        $payments = $this->paymentI->getAll($merchantId);

        return $payments;
    }
}
