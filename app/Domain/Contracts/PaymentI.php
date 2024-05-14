<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Dtos\Payment\Payment;
use Illuminate\Pagination\LengthAwarePaginator;

interface PaymentI
{
    public function get(string $id, int $merchantId): array;

    public function getAll(int $merchantId): LengthAwarePaginator;

    public function create(Payment $payment): Payment;
}
