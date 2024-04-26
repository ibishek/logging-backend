<?php

namespace App\DTO;

use App\Models\User;

class UserDTO
{
    public string $userName;

    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $password,
        public string $gender,
        public string $maritalStatus
    ) {
        $this->userName = str_replace('-', '_', User::getSlug($this->firstName, $this->lastName));
    }
}
