<?php

namespace App\DTO;

use App\Models\User;

class UserDTO
{
    public string $firstName;
    public string $lastName;
    public string $userName;
    public string $email;
    public string $password;
    public string $gender;
    public string $maritalStatus;

    public function __construct(
        array $validated
    ) {
        $this->firstName = $validated['first_name'];
        $this->lastName = $validated['last_name'];
        $this->userName = str_replace('-', '_', User::getSlug($this->firstName, $this->lastName));
        $this->email = $validated['email'];
        $this->password = $validated['password'];
        $this->gender = $validated['gender'];
        $this->maritalStatus = $validated['marital_status'];
    }
}
