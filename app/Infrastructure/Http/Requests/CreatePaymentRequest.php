<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use App\Infrastructure\Http\Requests\ValidationRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    private const REQUEST_ATTRIBUTES = [
        'name',
        'cpf',
        'description',
        'amount',
        'payment_method',
        'paidAt',
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
            'amount' => 'required|integer|gt:0',
            'payment_method' => 'required|exists:payment_method,slug',
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
        $cpf = $this->request->get('cpf');
        
        $this->removeMask($cpf);
        $this->replace($this->only(self::REQUEST_ATTRIBUTES));
    }

    private function removeMask(string $cpf): void
    {
        $this->request->add([
            'cpf' => preg_replace('/[^0-9]/', '', $cpf)
        ]);
    }
}
