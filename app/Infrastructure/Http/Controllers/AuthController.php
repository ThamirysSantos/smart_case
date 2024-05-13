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
    
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $merchant = new Register(
                $request->get('name'),
                $request->get('email'),
                $request->get('password'),
                $request->amount
            );
    
            $newMerchant = $this->registerUseCase->execute($merchant);
            return response()->json($newMerchant, Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

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
            return $this->sendResponse($e->getLine(), Response::HTTP_UNAUTHORIZED);
        } catch(\Throwable $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
  
        return $this->sendResponse(
            ['message' => 'Successfully logged out'],
            Response::HTTP_OK
        );
    }
    
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(Auth::Refresh());
    }

    protected function respondWithToken($token): JsonResponse
    {
        return $this->sendResponse(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60
            ],
            Response::HTTP_OK
        );
    }
}
