<?php

declare(strict_types=1);

namespace App\Domain\Dtos\Auth;

class Login
{
    public function __construct(
        public string $email = '',
        public string $password = ''
    ) { }

    public function toArray() {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
