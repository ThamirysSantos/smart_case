<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use OpenApi\Annotations as OA;
use \Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *    version="1.0.0",
 *    title="Smart Case",
 *    description="API Documentation",
 *    @OA\Contact(
 *        email="thamirysgoncalves.prog@gmail.com"
 *    )
 * )
 * 
 * @OA\PathItem(path="/api")
 * 
 * 
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\Tag(
 *     name="Authentication",
 *     description="Authentication endpoints"
 * ),
 * 
 * @OA\Tag(
 *     name="Payments",
 *     description="Payments endpoints"
 * ),
 * 
*/

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
