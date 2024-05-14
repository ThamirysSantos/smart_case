<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Dtos\Payment\GetPayment;
use App\Domain\Dtos\Payment\Payment;
use App\UseCase\CreatePaymentUseCase;
use App\UseCase\GetPaymentUseCase;
use App\UseCase\ListPaymentsUseCase;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\CreatePaymentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function __construct(
        private CreatePaymentUseCase $createPaymentUseCase,
        private GetPaymentUseCase $getPaymentUseCase,
        private ListPaymentsUseCase $listPaymentsUseCase,
    ){}

    public function index()
    {
        try {
            $merchant = auth()->user();

            $pagination = $this->listPaymentsUseCase
                ->execute($merchant->id);

            return $this->sendResponse($pagination, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return $this->sendError(
                $e->getMessage(), 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(string $id)
    {
        try {
            $merchant = auth()->user();
            $payment = new GetPayment(
                $merchant->id,
                $id,
            );

            $paymentFetched = $this->getPaymentUseCase->execute($payment);

            return $this->sendResponse($paymentFetched, Response::HTTP_OK);
        } catch (ModelNotFoundException $e){
            return $this->sendError($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return $this->sendError(
                $e->getMessage(), 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(CreatePaymentRequest $request)
    {
        try {
            $merchant = auth()->guard('api')->user();

            $payment = new Payment(
                $merchant->id,
                $request->get('name'),
                $request->get('cpf'),
                $request->get('description'),
                $request->get('amount'),
                $request->get('payment_method'),
                null,
            );

            $newPayment = $this->createPaymentUseCase->execute($payment);
            return $this->sendResponse($newPayment, Response::HTTP_CREATED);
        } catch (ModelNotFoundException $e){
            return $this->sendError($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return $this->sendError(
                $e->getMessage(), 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
