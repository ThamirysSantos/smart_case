<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Domain\Contracts\PaymentI;
use App\Domain\Dtos\Payment\GetPayment;

class GetPaymentUseCase
{
    public function __construct(
        private PaymentI $paymentI,
    ){
    }

    public function execute(GetPayment $paymentToFetch): array
    {
        $paymentDetails = $this->paymentI
            ->get($paymentToFetch->paymentId, $paymentToFetch->merchantId);
        
        return $paymentDetails;
    }
}
