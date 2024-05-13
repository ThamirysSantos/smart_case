<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Dtos\Payment\Payment;
use App\UseCase\CreatePaymentUseCase;
use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private CreatePaymentUseCase $createPaymentUseCase,
    ){}

    public function store(Request $request)
    {
        $merchant = auth()->user();

        $payment = new Payment(
            $merchant->id,
            $request->get('nameClient'),
            $request->get('cpf'),
            $request->get('description'),
            $request->get('amount'),
            $request->get('paymentMethod'),
            $request->get('paidAt'),
        );

        $newPayment = $this->createPaymentUseCase->execute($payment);
        return response()->json($newPayment, 201);
    }
}
