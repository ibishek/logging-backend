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
}
