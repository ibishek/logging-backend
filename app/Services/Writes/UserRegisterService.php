<?php

namespace App\Services\Writes;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRegisterService
{
    public function create(UserDTO $user): User
    {
        return User::create([
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'email' => $user->email,
            'user_name' => $user->userName,
            'gender' => $user->gender,
            'marital_status' => $user->maritalStatus,
            'password' => Hash::make($user->password),
        ]);
    }
}
