<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Dtos\Payment\Payment;
use App\Domain\Contracts\PaymentI;
use App\Infrastructure\Persistence\Models\PaymentModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentRepository implements PaymentI
{
    public function __construct(
        private readonly PaymentModel $model
    ) {
    }

    public function getAll(int $merchantId): LengthAwarePaginator
    {
        $payments = $this->model
                ->where(['merchant_id' => $merchantId])
                ->paginate(5);

        return  $payments;
    }

    public function get(string $id, int $merchantId): array
    {
        $payment = $this->model->where(
                ['id'=> $id, 'merchant_id' => $merchantId]
            )->first();

        if(empty($payment)){
            throw new ModelNotFoundException("Payment Not found by id $id");
        }

        return $payment->toArray();
    }

    public function create(Payment $payment): Payment
    {
        $this->model->create($payment->toArray());

        return $payment;
    }
}
