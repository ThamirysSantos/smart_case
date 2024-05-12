<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Dtos\Register;
use App\Domain\Dtos\Login;
use App\UseCase\RegisterUseCase;
use App\UseCase\LoginUseCase;
use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Error;

class AuthController extends Controller
{
    public function __construct(
        private RegisterUseCase $registerUseCase,
        private LoginUseCase $loginUseCase,
    ){}

    public function register(Request $request)
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

    public function login(Request $request)
    {
        $credentials = new Login(
            $request->get('email'),
            $request->get('password'),
        );
            
        $response = $this->loginUseCase->execute($credentials);
        return response()->json($response, 200);
    }

    // public function profile()
    // {

    // }

    // public function logout()
    // {

    // }
}
