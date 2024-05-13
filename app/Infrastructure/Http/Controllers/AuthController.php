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
use Illuminate\Support\Facades\Auth;

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

       /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        dd(auth()->attempt($credentials));
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
  
        return $this->respondWithToken($token);
    }
  
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
  
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
  
        return response()->json(['message' => 'Successfully logged out']);
    }
  
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::Refresh());
    }
  
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    // public function login(LoginRequest $request)
    // {
    //     $credentials = new Login(
    //         $request->get('email'),
    //         $request->get('password'),
    //     );

    //     $response = $this->loginUseCase->execute($credentials);
    //     return response()->json($response, 200);
    // }
}
