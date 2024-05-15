<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use App\Infrastructure\Http\Requests\ValidationRequest;
use OpenApi\Annotations as OA;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="Register Request",
 *     description="request body",
 *     @OA\Xml(
 *         name="Register"
 *     )
 * )
 */
class RegisterRequest extends FormRequest
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Merchant name",
     *     example="Thamirys"
     * )
     *
     * @var string
     */
    private $name;

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

    /**
     * @OA\Property(
     *     title="Amount",
     *     description="Merchant amount",
     *     example=100
     * )
     *
     * @var float
     */
    private $amount;

    private const REQUEST_ATTRIBUTES = [
        'name',
        'email',
        'password',
        'amount'
    ];

    public function __construct(
        private ValidationRequest $validationRequest
    ) {
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:merchant,email',
            'password' => 'required',
            'amount' => 'numeric|gt:0'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute is required and must be filled in',
            'string' => ':attribute must be of type string',
            'numeric' => ':attribute must be of type numeric',
            'gt' => ':attribute must be grather then 0'
        ];
    }

    protected function prepareForValidation()
    {
        $this->sanitizeJsonRequest();
    }

    public function failedValidation(Validator $validator)

    {
        $this->validationRequest->handleFailedValidation($validator);
    }

    /**
     * Remove unexpected attributes from request body.
     */
    private function sanitizeJsonRequest(): void
    {
        $amount = $this->request->get('amount');

        if($amount) {
            $this->request->add([
                'amount' => (float) $this->request->get('amount')
            ]);   
        }

        $this->replace($this->only(self::REQUEST_ATTRIBUTES));
    }
}
