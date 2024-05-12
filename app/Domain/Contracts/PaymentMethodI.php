<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Dtos\PaymentMethod;

interface PaymentMethodI
{
    public function get(int $id): PaymentMethod;

    public function create(PaymentMethod $paymentMethod): void;
}
