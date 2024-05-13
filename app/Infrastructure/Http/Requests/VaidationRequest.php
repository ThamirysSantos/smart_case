<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

// use Illuminate\Contracts\Validation\Validator;
// use Illuminate\Http\Exceptions\HttpResponseException;
// use Illuminate\Http\Response;
// use Illuminate\Support\Facades\Log;
// use App\Utils\ErrorsCode;

// class ValidationRequest
// {
//     public function handleFailedValidation(Validator $validator): void
//     {
//         Log::error($validator->errors()->first(), ErrorsCode::NOT_APPROVED);
//         throw new HttpResponseException(
//             response()->json(ErrorsCode::NOT_APPROVED, Response::HTTP_OK),
//         );
//     }
// }
