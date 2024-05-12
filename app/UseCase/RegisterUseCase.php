<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Domain\Contracts\MerchantI;
use App\Domain\Dtos\Register;
use Illuminate\Support\Facades\Hash;

class RegisterUseCase
{
    public function __construct(
        private MerchantI $merchantI,
        private Register $merchant,
    ){}

    public function execute(Register $register): array
    {
        $newMerchant = $this->merchantI->create($register);

        return $newMerchant->toArray(); 
    }
}
