<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Repositories;

use Domain\DTOs\PaymentMethod;
use Domain\Interfases\PaymentMethodI;
use Infrastructure\Persistence\Models\PaymentMethodModel;
use Error;

class PaymentMethodRepository implements PaymentMethodI
{
    public function __construct(
        private readonly PaymentMethodModel $model
    ) {
    }

    public function get(int $id): PaymentMethod
    {
        try {
            $paymentMethod = $this->model->findOrFail($id);
        } catch (\Throwable $e) {
            throw new Error('Merchant', $id);
        }

        return new PaymentMethod(...$paymentMethod);
    }

    public function create(PaymentMethod $paymentMethod): void
    {
        $this->model->create($paymentMethod);
    }
}
