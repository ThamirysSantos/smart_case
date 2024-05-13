<?php

declare(strict_types=1);

namespace App\UseCase;

USE App\Domain\Contracts\MerchantI;
use App\Domain\Contracts\PaymentI;
use App\Domain\Dtos\Payment\Payment;
use App\Util\PaymentProvider;
use App\Util\RateCalculator;
use App\Util\StatusEnum;
use Illuminate\Support\Carbon;

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
        $paymentStatus = $this->getPaymentStatus();
        $payment->setStatus($paymentStatus->value);

        if($paymentStatus == StatusEnum::PAID) {
            $payment->setPaidAt(Carbon::now()->toDateTimeString());
        }

        $newPayment = $this->paymentI->create($payment);
        $amountWithRateCalculated = $this
            ->caculateMerchantAmount($newPayment);

        $this->merchantI->updateAmount($newPayment->merchantId, $amountWithRateCalculated);

        return $newPayment->toArray();
    }

    private function getPaymentStatus(): StatusEnum
    {
        $processPayment = $this->paymentProvider->execute();

        if ($processPayment){
            return StatusEnum::PAID;
        }

        return StatusEnum::FAILED;
    }

    private function caculateMerchantAmount(Payment $newPayment): int
    {
        $rateCalculated = $this
            ->rateCalculator->execute($newPayment->amount, $newPayment->paymentMethod);
        $merchantAmount = $this->merchantI->getAmount($newPayment->merchantId);

        $newAmount = ($merchantAmount + $newPayment->amount) - $rateCalculated;

        return $newAmount;
    }
}
