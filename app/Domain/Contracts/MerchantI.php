<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Dtos\Auth\Register;
use App\Domain\Dtos\Auth\Merchant;

interface MerchantI
{
    public function create(Register $register): Merchant;
    
    public function login(string $email): Merchant;
}
