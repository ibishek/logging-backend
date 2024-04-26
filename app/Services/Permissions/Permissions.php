<?php

namespace App\Services\Permissions;

class Permissions
{
    /**
     * Provide permissions implementing web guard.
     *
     * @return array<string>
     */
    public static function webGuardPermissions(): array
    {
        return array_unique(array_merge(
            SubordinatePermissions::permissions(),
            SupervisorPermissions::permissions(),
            ProjectManagerPermissions::permissions(),
            OrgAdminPermissions::permissions(),
        ));
    }

    /**
     * Provide permissions implementing admin guard.
     *
     * @return array<string>
     */
    public static function adminGuardPermissions(): array
    {
        return TopLevelPermissions::permissions();
    }

    /**
     * Provide all available permissions.
     *
     * @return array<string>
     */
    public static function all(): array
    {
        return array_unique(array_merge(
            static::adminGuardPermissions(),
            static::webGuardPermissions(),
        ));
    }
}
