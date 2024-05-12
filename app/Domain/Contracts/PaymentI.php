<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Dtos\Payment;

interface PaymentI
{
    public function get(int $id): Payment;

    public function create(Payment $payment): void;
}
