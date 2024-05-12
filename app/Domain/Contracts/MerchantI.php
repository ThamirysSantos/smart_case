<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Dtos\Register;
use App\Domain\Dtos\Merchant;

interface MerchantI
{
    public function create(Register $register): Merchant;
    public function getbyEmail(string $email): Merchant;
}
