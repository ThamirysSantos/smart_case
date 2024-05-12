<?php

declare(strict_types=1);

namespace App\Domain\Dtos;

class Register
{
    public string $name;
    public string $email;
    public string $password;
    public int $amount;

    public function __construct(string $name = '', string $email = '', string $password = '', int $amount = 0)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->amount = $amount;
    }

    public function toArray() {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'amount' => $this->amount,
        ];
    }

    public function setPasswordHashed(string $hash)
    {
        $this->password = $hash;
    }
}
