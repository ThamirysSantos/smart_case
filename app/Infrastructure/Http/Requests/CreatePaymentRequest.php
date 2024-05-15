<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use App\Infrastructure\Http\Requests\ValidationRequest;
use OpenApi\Annotations as OA;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="Create Payment Request",
 *     description="request body",
 *     @OA\Xml(
 *         name="Create Payment"
 *     )
 * )
 */
class CreatePaymentRequest extends FormRequest
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Client name",
     *     example="Client"
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     title="CPF",
     *     description="cpf",
     *     example="520.833.190-01"
     * )
     *
     * @var string
     */
    private $cpf;

    /**
     * @OA\Property(
     *     title="Description",
     *     description="Some description",
     *     example="this is a description"
     * )
     *
     * @var string
     */
    private $description;

    /**
     * @OA\Property(
     *     title="Amount",
     *     description="Payment amount",
     *     example=50
     * )
     *
     * @var float
     */
    private $amount;

    /**
     * @OA\Property(
     *     title="Payment Method",
     *     description="Payment method permited [pix, boleto, bank-transfer]",
     *     example="bank-transfer"
     * )
     *
     * @var string
     */
    private $payment_method;

    private const REQUEST_ATTRIBUTES = [
        'name',
        'cpf',
        'description',
        'amount',
        'payment_method',
    ];

    public function __construct(
        private ValidationRequest $validationRequest
    ) {
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'cpf' => 'required|cpf',
            'description' => 'required|string',
            'amount' => 'required|numeric|gt:0',
            'payment_method' => 'required|exists:payment_method,slug',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute is required and must be filled in',
            'string' => ':attribute must be of type string',
            'exists' => ':attribute not found',
            'numeric' => ':attribute must be of type numeric',
            'gt' => ':attribute must be grather then 0'
        ];
    }

    protected function prepareForValidation()
    {
        $this->sanitizeJsonRequest();
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validationRequest->handleFailedValidation($validator);
    }

    /**
     * Remove unexpected attributes from request body.
     */
    private function sanitizeJsonRequest(): void
    {
        $this->request->add([
            'amount' => (float) $this->request->get('amount')
        ]);

        $this->request->add([
            'cpf' => preg_replace('/[^0-9]/', '', $this->request->get('cpf'))
        ]);

        $this->replace($this->only(self::REQUEST_ATTRIBUTES));
    }
}
