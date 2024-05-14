<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Dtos\Auth\Merchant;
use App\Domain\Dtos\Auth\Register;
use App\Domain\Contracts\MerchantI;
use App\Infrastructure\Persistence\Models\MerchantModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MerchantRepository implements MerchantI
{
    public function __construct(
        private readonly MerchantModel $model
    ) {
    }

    public function create(Register $register): Merchant
    {
        $newMerchant = $this->model->create($register->toArray());

        return $this->formatData($newMerchant, null);
    }

    public function getAmount(int $merchantId): float
    {
        $merchant = $this->model->find($merchantId);

        if(empty($merchant)) {
            throw new ModelNotFoundException("Merchant Not found");
        }
        return $merchant->amount;
    }

    public function updateAmount(int $merchantId, float $amount): void
    {
        $merchant = $this->model->find($merchantId);
        if(empty($merchant)) {
            throw new ModelNotFoundException("Merchant Not found");
        } else {
            $merchant->update(['amount' => $amount]);
        }
    }

    private function formatData(MerchantModel $merchantData, ?string $token): Merchant
    {
        return new Merchant(
            $merchantData->id,
            $merchantData->name,
            $merchantData->email,
            $merchantData->password,
            $merchantData->amount,
            $token,
        );
    }
}
