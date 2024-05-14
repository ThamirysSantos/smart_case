<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Domain\Contracts\MerchantI;
use App\Domain\Dtos\Auth\Register;

class RegisterUseCase
{
    public function __construct(
        private MerchantI $merchantI,
        private Register $merchant,
    ){
    }

    public function execute(Register $register): array
    {
        $encryptedPassword = $this->encryptPassword($register->password);
        $register->setEncryptedPassword($encryptedPassword);

        return $this->merchantI->create($register)->toArray();
    }

    private function encryptPassword(string $password): string
    {
        return bcrypt($password);
    }
}
