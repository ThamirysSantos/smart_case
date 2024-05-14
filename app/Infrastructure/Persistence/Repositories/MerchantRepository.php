<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Dtos\Auth\Merchant;
use App\Domain\Dtos\Auth\Register;
use App\Domain\Contracts\MerchantI;
use App\Infrastructure\Persistence\Models\MerchantModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MerchantRepository implements MerchantI
{
    public function __construct(
        private readonly MerchantModel $model
    ) {
    }

    public function create(Register $register): Merchant
    {
        try {
            $newMerchant = $this->model->create($register->toArray());
        } catch (\Throwable) {
            throw new Exception('Error while creating new Merchant');
        }

        return $this->formatData($newMerchant, null);
    }

    public function getAmount(int $merchantId): int
    {
        try {
            $merchant = $this->model->where(['id' => $merchantId]);
            
            if(empty($merchant)) {
                throw new ModelNotFoundException("Merchant Not found");
            }
        } catch (\Throwable) {
            throw new Exception('Error while fetching merchant amount');
        }

        return $merchant->amount;
    }

    public function updateAmount(int $merchantId, int $amount): void
    {
        try {
            $merchant = $this->model->where(['id' => $merchantId]);
            if(empty($merchant)) {
                throw new ModelNotFoundException("Merchant Not found");
            } else {
                $merchant->update(['amount' => $amount]);
            }
        } catch (\Throwable) {
            throw new Exception('Error while updating merchant maount');
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
            $merchantData->created_at->format('Y-m-d'),
            $merchantData->updated_at->format('Y-m-d'), 
            $token,
        );
    }
}
