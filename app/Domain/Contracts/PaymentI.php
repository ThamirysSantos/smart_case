<?php

declare(strict_types=1);

namespace Domain\Interfases;

use Domain\DTOS\Payment;

interface PaymentI
{
    public function get(int $id): Payment;

    public function create(Payment $payment): void;
}
