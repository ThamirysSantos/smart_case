<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Dtos\Merchant;

interface MerchantI
{
    public function get(int $id): Merchant;

    public function create(Merchant $merchant): void;
}
