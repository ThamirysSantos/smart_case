<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Auth;

class Merchant
{
    public function __construct(
        public int $id, 
        public string $name, 
        public string $email, 
        public ?string $password, 
        public int $amount,
        public string $createdAt, 
        public ?string $updatedAt,
        public ?string $token,
    ) {}

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'amount' => $this->amount,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'token' => $this->token,
        ];
    }
}
