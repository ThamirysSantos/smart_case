<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Auth;

class Register
{
    public function __construct(
        public string $name = '',
        public string $email = '',
        public string $password = '',
        public float $amount = 0
    ) {}

    public function toArray() {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'amount' => $this->amount,
        ];
    }

    public function setEncryptedPassword(string $encryp)
    {
        $this->password = $encryp;
    }
}
