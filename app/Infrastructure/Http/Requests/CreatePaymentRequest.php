<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use App\Infrastructure\Http\Requests\ValidationRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    private const REQUEST_ATTRIBUTES = [
        'nameClient',
        'cpf',
        'description',
        'amount',
        'paymentMethod',
        'paidAt',
    ];

    public function __construct(
        private ValidationRequest $validationRequest
    ) {
    }

    public function rules()
    {
        return [
            'nameClient' => 'required|string',
            'cpf' => 'required|cpf',
            'description' => 'required|string',
            'amount' => 'required|integer',
            'paymentMethod' => 'required|exists:payment_method,slug',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute is required and must be filled in',
            'string' => ':attribute must be of type string',
            'integer' => ':attribute must be of type integer',
            'exists' => ':attribute not found',
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
        $this->replace($this->only(self::REQUEST_ATTRIBUTES));
    }
}
