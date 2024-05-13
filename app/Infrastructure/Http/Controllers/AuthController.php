<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Dtos\Auth\Register;
use App\Domain\Dtos\Auth\Login;
use App\Infrastructure\Http\Requests\LoginRequest;
use App\Infrastructure\Http\Requests\RegisterRequest;
use App\UseCase\RegisterUseCase;
use App\UseCase\LoginUseCase;
use App\Infrastructure\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct(
        private RegisterUseCase $registerUseCase,
        private LoginUseCase $loginUseCase,
    ){}

    public function register(RegisterRequest $request)
    {
        $merchant = new Register(
            $request->get('name'),
            $request->get('email'),
            $request->get('password'),
            $request->amount
        );

        $newMerchant = $this->registerUseCase->execute($merchant);
        return response()->json($newMerchant, 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = new Login(
            $request->get('email'),
            $request->get('password'),
        );

        $response = $this->loginUseCase->execute($credentials);
        return response()->json($response, 200);
        // $credentials = request(['email', 'password']);
  
        // if (! $token = auth()->guard('api')->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
  
        // return $this->respondWithToken($token);
    }

    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->guard('api')->factory()->getTTL() * 60,
    //     ]);
    // }
}
