<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ValidationRequest
{
    public function handleFailedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'error' => [
                'message'   => 'Validation errors',
                'data'      => $validator->errors()
            ]
        ], Response::HTTP_BAD_REQUEST));
    }
}
