<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Domain\Contracts\MerchantI;
use App\Domain\Dtos\Auth\Login;
use Error;

class LoginUseCase
{
    public function __construct(
        private MerchantI $merchantI,
        private Login $merchant,
    ){}

    public function execute(Login $credentials): array
    {
        if (auth()->attempt($credentials->toArray())) {
            $merchant = $this->merchantI->login($credentials->email);
            return $merchant->toArray();
        } else {
            throw new Error('Invalid credentials');
        }
    }
}
