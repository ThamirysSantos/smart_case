<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Dtos\Payment\Payment;

interface PaymentI
{
    public function getAll(int $merchantId): array;

    public function get(string $id, int $merchantId): array;

    public function create(Payment $payment): Payment;
}
