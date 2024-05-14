<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Domain\Contracts\MerchantI;
use App\Domain\Dtos\Auth\Login;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class LoginUseCase
{
    public function __construct(
        private MerchantI $merchantI,
        private Login $merchant,
    ){}

    public function execute(Login $credentials): string
    {
        if (!$token = auth()->attempt($credentials->toArray())) {
            throw new JWTException('Invalid credentials');
        } else {
            return $token;
        }
    }
}
