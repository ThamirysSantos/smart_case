<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use OpenApi\Annotations as OA;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;


class ValidationRequest
{
    private $data;

    public function handleFailedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], Response::HTTP_BAD_REQUEST));
    }
}
