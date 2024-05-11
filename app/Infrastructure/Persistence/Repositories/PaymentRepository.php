<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Repositories;

use Domain\DTOs\Payment;
use Domain\Interfases\PaymentI;
use Infrastructure\Persistence\Models\PaymentModel;
use Error;

class PaymentRepository implements PaymentI
{
    public function __construct(
        private readonly PaymentModel $model
    ) {
    }

    public function get(int $id): Payment
    {
        try {
            $payment = $this->model->findOrFail($id);
        } catch (\Throwable $e) {
            throw new Error('Merchant', $id);
        }

        return new Payment(...$payment);
    }

    public function create(Payment $payment): void
    {
        $this->model->create($payment);
    }
}
