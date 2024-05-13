<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Dtos\Payment\PaymentMethod;
use App\Domain\Contracts\PaymentMethodI;
use App\Infrastructure\Persistence\Models\PaymentMethodModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentMethodRepository implements PaymentMethodI
{
    public function __construct(
        private readonly PaymentMethodModel $model
    ) {
    }

    public function get(int $id): PaymentMethod
    {
        try {
            $paymentMethod = $this->model->where(['id', $id]);
            if(empty($paymentMethod)){
                throw new ModelNotFoundException("Payment Method Not found");
            }
        } catch (\Throwable) {
            throw new Exception('Error while fetching payment method');
        }

        return new PaymentMethod(...$paymentMethod);
    }

    public function create(PaymentMethod $paymentMethod): void
    {
        try {
            $this->model->create($paymentMethod);
        } catch (\Throwable) {
            throw new Exception('Error while creating new payment method');
        }
    }
}
