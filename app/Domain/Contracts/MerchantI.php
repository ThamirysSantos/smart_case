<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Dtos\Auth\Register;
use App\Domain\Dtos\Auth\Merchant;

interface MerchantI
{
    public function create(Register $register): Merchant;

    public function getAmount(int $merchantId): int;

    public function updateAmount(int $merchantId, int $amount): void;
}
