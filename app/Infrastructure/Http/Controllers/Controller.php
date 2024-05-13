<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use \Illuminate\Http\JsonResponse;

abstract class Controller
{
    public function sendResponse($result, $statusCode): JsonResponse
    {
        $response = [
            'data'    => $result,
        ];
  
        return response()->json($response, $statusCode);
    }

    public function sendError($error, $statusCode): JsonResponse
    {
        $response = [
            'error' => [
                'message' => $error,
            ]
        ];
  
        return response()->json($response, $statusCode);
    }
}
