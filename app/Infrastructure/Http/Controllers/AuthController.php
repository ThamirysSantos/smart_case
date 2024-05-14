<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Dtos\Auth\Login;
use App\Domain\Dtos\Auth\Register;
use App\Infrastructure\Http\Requests\RegisterRequest;
use App\UseCase\RegisterUseCase;
use App\UseCase\LoginUseCase;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct(
        private RegisterUseCase $registerUseCase,
        private LoginUseCase $loginUseCase,
    ){}
    
    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register a new merchant",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/RegisterRequest"
     *              )
     *          )
     *     ),
     *     @OA\Response(response="201", description="Merchant registered successfully"),
     *     @OA\Response(response="422",description="Validation errors")
     *     )
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $merchant = new Register(
                $request->get('name'),
                $request->get('email'),
                $request->get('password'),
                $request->get('amount', 0),
            );
    
            $newMerchant = $this->registerUseCase->execute($merchant);
            return response()->json($newMerchant, Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Authenticate merchant and generate JWT token",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/LoginRequest"
     *              )
     *          )
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = new Login(
                $request->get('email'),
                $request->get('password'),
            );
            
            $token = $this->loginUseCase->execute($credentials);

            return $this->respondWithToken($token);
        } catch(JWTException $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } catch(\Throwable $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * @OA\Post(
     *     path="/api/me",
     *     tags={"Authentication"},
     *     summary="Get merchant",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Merchant fetched successfully"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="Get merchant",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Merchant logout successfully"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
  
        return $this->sendResponse(
            ['message' => 'Successfully logged out'],
            Response::HTTP_OK
        );
    }
    
    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     tags={"Authentication"},
     *     summary="Get merchant",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Token refreshed successfully"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ],
        Response::HTTP_OK);
    }
}
