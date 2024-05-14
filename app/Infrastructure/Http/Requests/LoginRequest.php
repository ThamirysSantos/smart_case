<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use App\Infrastructure\Http\Requests\ValidationRequest;
use OpenApi\Annotations as OA;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="Login Request",
 *     description="request body",
 *     @OA\Xml(
 *         name="Login"
 *     )
 * )
 */
class LoginRequest extends FormRequest
{
    /**
     * @OA\Property(
     *     title="Email",
     *     description="Merchant email",
     *     example="Thamirys@gmail.com"
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(
     *     title="Password",
     *     description="Merchant password",
     *     example="secret"
     * )
     *
     * @var string
     */
    private $password;

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
