<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Auth;

class Login
{
    public string $email;
    public string $password;

    public function __construct(string $email = '', string $password = '')
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function toArray() {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
