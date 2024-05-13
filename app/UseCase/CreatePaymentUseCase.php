<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Domain\Contracts\PaymentI;
use App\Domain\Dtos\Payment\Payment;

class CreatePaymentUseCase
{
    public function __construct(
        private PaymentI $merchantI,
        private Payment $merchant,
    ){}

    public function execute(Payment $payment): array
    {
        $newPayment = $this->merchantI->create($payment);

        return $newPayment->toArray();
    }
}
