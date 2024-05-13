<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Dtos\Auth\Merchant;
use App\Domain\Dtos\Auth\Register;
use App\Domain\Contracts\MerchantI;
use App\Infrastructure\Persistence\Models\MerchantModel;
use App\Util\CodeErrors;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MerchantRepository implements MerchantI
{
    public function __construct(
        private readonly MerchantModel $model
    ) {
    }

    public function login(string $email): Merchant
    {
        try {
            $merchantFetched = $this->model->where(['email' => $email])->first();
            if(empty($merchantFetched)) {
                throw new ModelNotFoundException(
                    "Merchant Not found by email", 
                    CodeErrors::NOT_FOUND
                );
            } else {
                $token = $merchantFetched->createToken('secret')->plainTextToken;

                return $this->formatData($merchantFetched, $token);
            }
        } catch (\Throwable) {
            throw new Exception('Error processing login', CodeErrors::NOT_FOUND);
        }
    }

    public function create(Register $register): Merchant
    {
        try {
            $newMerchant = $this->model->create($register->toArray());
        } catch (\Throwable) {
            throw new Exception(
                'Error while creating new Merchant', 
                CodeErrors::INTERNAL_SERVER_ERROR
            );
        }

        return $this->formatData($newMerchant, null);
    }

    public function getAmount(int $merchantId): int
    {
        try {
            $merchant = $this->model->where(['id' => $merchantId]);
            
            if(empty($merchant)) {
                throw new ModelNotFoundException(
                    "Merchant Not found", 
                    CodeErrors::NOT_FOUND
                );
            }
        } catch (\Throwable) {
            throw new Exception(
                'Error while fetching merchant amount', 
                CodeErrors::INTERNAL_SERVER_ERROR
            );
        }

        return $merchant->amount;
    }

    public function updateAmount(int $merchantId, int $amount): void
    {
        try {
            $merchant = $this->model->where(['id' => $merchantId]);
            if(empty($merchant)) {
                throw new ModelNotFoundException(
                    "Merchant Not found", 
                    CodeErrors::NOT_FOUND
                );
            } else {
                $merchant->update(['amount' => $amount]);
            }
        } catch (\Throwable) {
            throw new Exception(
                'Error while updating merchant maount', 
                CodeErrors::INTERNAL_SERVER_ERROR
            );
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
