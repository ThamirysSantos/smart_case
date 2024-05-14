<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Domain\Contracts\PaymentI;
use Illuminate\Pagination\LengthAwarePaginator;

class ListPaymentsUseCase
{
    public function __construct(
        private PaymentI $paymentI,
    ){
    }

    public function execute(int $merchantId): LengthAwarePaginator
    {
        $payments = $this->paymentI->getAll($merchantId);

        return $payments;
    }
}
