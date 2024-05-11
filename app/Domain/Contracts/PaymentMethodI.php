<?php

declare(strict_types=1);

namespace Domain\Interfases;

use Domain\DTOS\PaymentMethod;

interface PaymentMethodI
{
    public function get(int $id): PaymentMethod;

    public function create(PaymentMethod $paymentMethod): void;
}
