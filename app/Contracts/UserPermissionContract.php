<?php

namespace App\Contracts;

interface UserPermissionContract
{
    /**
     * Role specific permissions.
     *
     * @return array<string>
     */
    public static function permissions(): array;
}
