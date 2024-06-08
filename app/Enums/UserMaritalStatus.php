<?php

namespace App\Enums;

enum UserMaritalStatus: string
{
    case UNMARRIED = 'unmarried';
    case MARRIED = 'married';

    /**
     * Get the enum cases in array.
     *
     * @return array<string>
     */
    public static function toArray(): array
    {
        return array_map(fn (UserMaritalStatus $status) => $status->value, self::cases());
    }

    public static function maritalStatus(int|string|null $status): string|int|null
    {
        if (gettype($status) === 'integer') {
            return match ($status) {
                1 => UserMaritalStatus::UNMARRIED->value,
                2 => UserMaritalStatus::MARRIED->value,
                default => null
            };
        }

        if (gettype($status) === 'string') {
            return match ($status) {
                UserMaritalStatus::UNMARRIED->value => 1,
                UserMaritalStatus::MARRIED->value => 2,
                default => null
            };
        }

        return null;
    }
}
