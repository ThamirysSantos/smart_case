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
        if (auth()->attempt($credentials->toArray())) {
            $merchant = $this->merchantI->login($credentials->email);
            return $merchant->token;
        } else {
            throw new JWTException('Invalid credentials');
        }
    }
}
