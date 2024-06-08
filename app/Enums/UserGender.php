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

    public static function gender(int|string|null $gender): int|string|null
    {
        if (gettype($gender) === 'string') {
            return match ($gender) {
                UserGender::MALE->value => 1,
                UserGender::FEMALE->value => 2,
                UserGender::OTHER->value => 3,
                default => null,
            };
        }

        if (gettype($gender) === 'integer') {
            return match ($gender) {
                1 => UserGender::MALE->value,
                2 => UserGender::FEMALE->value,
                3 => UserGender::OTHER->value,
                default => null,
            };
        }

        return null;
    }
}
