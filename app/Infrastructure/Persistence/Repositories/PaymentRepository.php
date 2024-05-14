<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Dtos\Payment\Payment;
use App\Domain\Contracts\PaymentI;
use App\Infrastructure\Persistence\Models\PaymentModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentRepository implements PaymentI
{
    public function __construct(
        private readonly PaymentModel $model
    ) {
    }

    public function getAll(int $merchantId): array
    {
        try {
            $payments = $this->model->paginate()
                ->where(['merchant_id' => $merchantId]);
            return new $payments;
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get(string $id, int $merchantId): array
    {
        try {
            $payment = $this->model->where(
                ['id'=> $id, 'merchant_id' => $merchantId]
            )->first();

            if(empty($payment)){
                throw new ModelNotFoundException("Payment Not found by id $id");
            }

            return $payment->toArray();
        } catch (\Throwable) {
            throw new Exception('Error while fetching payment');
        }
    }

    public function create(Payment $payment): Payment
    {
        try {
            $this->model->create($payment->toArray());
            
            return $payment;

        } catch (\Throwable) {
            throw new Exception('Error while creating a new payment');
        }
    }
}
