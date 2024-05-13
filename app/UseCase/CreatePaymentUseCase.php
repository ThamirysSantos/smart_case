<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Domain\Contracts\PaymentI;
use App\Domain\Dtos\Payment\Payment;

class CreatePaymentUseCase
{
    const PIX_FEE_RATE = 0.015; // 1.5%
    const BOLETO_FEE_RATE = 0.02; // 2%
    const TRANSFER_FEE_RATE = 0.04; // 4%

    public function __construct(
        private PaymentI $merchantI,
        private Payment $merchant,
    ){}

    public function execute(Payment $payment): array
    {   
        // chamar o provider e atualizar o status

        // Se o pagamento retornar sucesso, adicionar saldo ao usuário.
        $newPayment = $this->merchantI->create($payment);

        return $newPayment->toArray();
    }

    private function rateCalculator(int $amount, string $paymentMethod)
    {
        switch ($paymentMethod) {
            case 'PIX':
                return $amount * self::PIX_FEE_RATE;
            case 'BOLETO':
                return $amount * self::BOLETO_FEE_RATE;
            case 'BANK_TRANSFER':
                return $amount * self::TRANSFER_FEE_RATE;
            default:
                return 0;
        }
    }

    private function paymentProvider(): bool
    {
        $success = mt_rand(1, 100) <= 70;

        if ($success) {
            return true;
        }
        return false;
    }
}
