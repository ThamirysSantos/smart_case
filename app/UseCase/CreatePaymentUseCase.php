<?php

declare(strict_types=1);

namespace App\UseCase;

USE App\Domain\Contracts\MerchantI;
use App\Domain\Contracts\PaymentI;
use App\Domain\Dtos\Payment\Payment;
use App\Util\PaymentProvider;
use App\Util\RateCalculator;

class CreatePaymentUseCase
{
    public function __construct(
        private MerchantI $merchantI,
        private PaymentI $paymentI,
        private PaymentProvider $paymentProvider,
        private RateCalculator $rateCalculator,
    ){}

    public function execute(Payment $payment): array
    {
        $paymentProcessed = $this->processPayment();

        ($paymentProcessed) ? $payment->paid() : $payment->failed();

        $newPayment = $this->paymentI->create($payment);

        if($paymentProcessed) {
            $amountWithRateCalculated = $this
                ->caculateMerchantAmount($newPayment);

            $this->merchantI->updateAmount(
                $newPayment->merchant_id,
                $amountWithRateCalculated
            );
        }
       

        return $newPayment->toArray();
    }

    private function processPayment(): bool
    {
        return $this->paymentProvider->execute();
    }

    private function caculateMerchantAmount(Payment $newPayment): float
    {
        $rateCalculated = $this
            ->rateCalculator->execute($newPayment->amount, $newPayment->payment_method);
        $merchantAmount = $this->merchantI->getAmount($newPayment->merchant_id);

        $newAmount = $merchantAmount($newPayment->amount - $rateCalculated);

        return $newAmount;
    }
}
