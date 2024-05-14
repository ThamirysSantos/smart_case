<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use OpenApi\Annotations as OA;

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

}
