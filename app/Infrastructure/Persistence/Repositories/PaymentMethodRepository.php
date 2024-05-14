<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Dtos\Payment\PaymentMethod;
use App\Domain\Contracts\PaymentMethodI;
use App\Infrastructure\Persistence\Models\PaymentMethodModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentMethodRepository implements PaymentMethodI
{
    public function __construct(
        private readonly PaymentMethodModel $model
    ) {
    }

    public function get(int $id): PaymentMethod
    {
        $paymentMethod = $this->model->where(['id', $id]);
        if(empty($paymentMethod)){
            throw new ModelNotFoundException("Payment Method Not found");
        }

        return new PaymentMethod(...$paymentMethod);
    }

    public function create(PaymentMethod $paymentMethod): void
    {
        $this->model->create($paymentMethod);
    }
}
