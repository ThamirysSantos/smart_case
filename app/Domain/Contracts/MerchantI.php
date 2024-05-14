<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Dtos\Auth\Register;
use App\Domain\Dtos\Auth\Merchant;

interface MerchantI
{
    public function create(Register $register): Merchant;

    public function getAmount(int $merchantId): float;

    public function updateAmount(int $merchantId, float $amount): void;
}
