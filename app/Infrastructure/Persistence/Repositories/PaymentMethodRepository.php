<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Dtos\PaymentMethod;
use App\Domain\Contracts\PaymentMethodI;
use App\Infrastructure\Persistence\Models\PaymentMethodModel;
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
