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
use Illuminate\Validation\UnauthorizedException;

class PaymentController extends Controller
{
    public function __construct(
        private CreatePaymentUseCase $createPaymentUseCase,
        private GetPaymentUseCase $getPaymentUseCase,
        private ListPaymentsUseCase $listPaymentsUseCase,
    ){}
    
    /**
     * @OA\Get(
     *     path="/api/payments",
     *     tags={"Payments"},
     *     summary="List merchant payments",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Payments listed successfully"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function index()
    {
        try {
            $merchant = auth()->user();

            $pagination = $this->listPaymentsUseCase
                ->execute($merchant->id);

            return response()->json($pagination, Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json(
                $e->getMessage(), 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/payments/{:id}",
     *     tags={"Payments"},
     *     summary="Get a merchant payment",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Payment fetched successfully"),
     *     @OA\Response(response="404", description="Payment Not Found"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function show(string $id)
    {
        try {
            $merchant = auth()->user();

            if (!$merchant) {
                throw new UnauthorizedException('Unauthorized');
            }

            $payment = new GetPayment(
                $merchant->id,
                $id,
            );

            $paymentFetched = $this->getPaymentUseCase->execute($payment);

            return response()->json($paymentFetched, Response::HTTP_OK);
        } catch (UnauthorizedException $e){
            return response()->json($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $e){
            return response()->json($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json(
                $e->getMessage(), 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/payments",
     *     tags={"Payments"},
     *     summary="Create a new payment",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/CreatePaymentRequest"
     *              )
     *          )
     *     ),
     *     @OA\Response(response="201", description="Payment registered successfully"),
     *     @OA\Response(response="422",description="Validation errors"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function store(CreatePaymentRequest $request)
    {
        try {
            $merchant = auth()->guard('api')->user();

            if (!$merchant) {
                throw new UnauthorizedException('Unauthorized');
            }

            $payment = new Payment(
                $merchant->id,
                $request->get('name'),
                $request->get('cpf'),
                $request->get('description'),
                $request->get('amount'),
                $request->get('payment_method')
            );

            $newPayment = $this->createPaymentUseCase->execute($payment);
            return response()->json($newPayment, Response::HTTP_CREATED);
        } catch (UnauthorizedException $e){
            return response()->json($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $e){
            return response()->json($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json(
                $e->getMessage(), 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
