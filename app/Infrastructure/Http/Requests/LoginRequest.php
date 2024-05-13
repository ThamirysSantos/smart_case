<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use App\Infrastructure\Http\Requests\ValidationRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    private const REQUEST_ATTRIBUTES = [
        'email',
        'password',
    ];

    public function __construct(
        private ValidationRequest $validationRequest
    ) {
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:merchant,email',
            'password' => 'required',
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
