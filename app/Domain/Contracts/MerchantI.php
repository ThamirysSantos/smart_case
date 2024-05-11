<?php

declare(strict_types=1);

namespace Domain\Interfases;

use Domain\DTOS\Merchant;

interface MerchantI
{
    public function get(int $id): Merchant;

    public function create(Merchant $merchant): void;
}
