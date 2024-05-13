<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Dtos\Auth\Merchant;
use App\Domain\Dtos\Auth\Register;
use App\Domain\Contracts\MerchantI;
use App\Infrastructure\Persistence\Models\MerchantModel;
use Error;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MerchantRepository implements MerchantI
{
    public function __construct(
        private readonly MerchantModel $model
    ) {
    }

    /**
     * @throws ModelNotFoundException
     */
    public function login(string $email): Merchant
    {
        try {
            $merchantFetched = $this->model->where(['email' => $email])->first();
            if(!empty($merchantFetched)) {
                $token = $merchantFetched->createToken('secret')->plainTextToken;

                return $this->formatData($merchantFetched, $token);
            } else {
                throw new ModelNotFoundException('Merchant Not found');
            }
        } catch (\Throwable $e) {
            throw new Error($e->getMessage());
        }
    }

    public function create(Register $register): Merchant
    {
        try {
            $newMerchant = $this->model->create($register->toArray());
        } catch (\Throwable $e) {
            throw new Error($e->getMessage());
        }

        return $this->formatData($newMerchant, null);
    }

    private function formatData(MerchantModel $merchantData, ?string $token): Merchant
    {
        return new Merchant(
            $merchantData->id,
            $merchantData->name,
            $merchantData->email,
            $merchantData->password,
            $merchantData->amount,
            $merchantData->email_verified_at,
            $merchantData->created_at->format('Y-m-d'),
            $merchantData->updated_at->format('Y-m-d'), 
            $token,
        );
    }
}
