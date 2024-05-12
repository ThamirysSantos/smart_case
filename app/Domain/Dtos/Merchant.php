<?php

declare(strict_types=1);

namespace App\Domain\Dtos;

class Merchant
{
    public function __construct(
        public int $id, 
        public string $name, 
        public string $email, 
        public ?string $password, 
        public int $amount, 
        public ?string $emailVerifiedAt, 
        public string $createdAt, 
        public ?string $updatedAt,
        public ?string $token,
    ){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->amount = $amount;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->token = $token;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'amount' => $this->amount,
            'emailVerifiedAt' => $this->emailVerifiedAt,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'token' => $this->token,
        ];
    }
}
