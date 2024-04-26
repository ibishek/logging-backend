<?php

namespace App\Enums;

enum UserGender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

    /**
     * Get the enum cases in array.
     *
     * @return array<string>
     */
    public static function toArray(): array
    {
        return array_map(fn (UserGender $gender) => $gender->value, self::cases());
    }
}
