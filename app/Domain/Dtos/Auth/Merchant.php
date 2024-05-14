<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Auth;

use Carbon\Carbon;

class Merchant
{
    public function __construct(
        public int $id, 
        public string $name, 
        public string $email, 
        public ?string $password, 
        public int $amount,
        public Carbon $created_at, 
        public ?Carbon $updated_at,
        public ?string $token,
    ) {}

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'amount' => $this->amount,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'token' => $this->token,
        ];
    }
}
