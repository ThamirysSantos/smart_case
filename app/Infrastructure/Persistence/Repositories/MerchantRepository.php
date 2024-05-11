<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Repositories;

use Domain\DTOs\Merchant;
use Domain\Interfases\MerchantI;
use Infrastructure\Persistence\Models\MerchantModel;
use Error;

class MerchantRepository implements MerchantI
{
    public function __construct(
        private readonly MerchantModel $model
    ) {
    }

    /**
     * @throws ModelNotFoundException
     */
    public function get(int $id): Merchant
    {
        try {
            $merchant = $this->model->findOrFail($id);
        } catch (\Throwable $e) {
            throw new Error('Merchant', $id);
        }

        return new Merchant(...$merchant);
    }

    public function create(Merchant $merchant): void
    {
        $this->model->create($merchant);
    }
}
