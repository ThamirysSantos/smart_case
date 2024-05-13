<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Dtos\Payment\Payment;
use App\Domain\Contracts\PaymentI;
use App\Infrastructure\Persistence\Models\PaymentModel;
use Error;

class PaymentRepository implements PaymentI
{
    public function __construct(
        private readonly PaymentModel $model
    ) {
    }

    public function getAll(): array
    {
        try {
            $payments = $this->model->findAll();
            return new $payments->toArray();
        } catch (\Throwable $e) {
            throw new Error($e->getMessage());
        }
    }

    public function get(int $id): Payment
    {
        try {
            $payment = $this->model->findOrFail($id);
        } catch (\Throwable $e) {
            throw new Error($e->getMessage());
        }

        return new Payment(...$payment);
    }

    public function create(Payment $payment): Payment
    {
        try {
            $newPayment =  $this->model->create([
                'merchant_id' => $payment->merchantId,
                'name_client' => $payment->nameClient,
                'cpf' => $payment->cpf,
                'description' => $payment->description,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'payment_method' => $payment->paymentMethod,
                'paid_at' => $payment->paidAt,
            ]);
            
            return new Payment(
                $newPayment->merchant_id,
                $newPayment->name_client,
                $newPayment->cpf,
                $newPayment->description,
                $newPayment->amount,
                $newPayment->payment_method,
                $newPayment->paid_at
            );

        } catch (\Throwable $e) {
            throw new Error($e->getMessage());
        }
    }
}
