<?php

namespace App\Services\Permissions;

use App\Contracts\UserPermissionContract;

class TopLevelPermissions implements UserPermissionContract
{
    /**
     * {@inheritDoc}
     */
    public static function permissions(): array
    {
        return [
            'application_log_view',
            'notification_create',
            'notification_update',
            'notification_broadcast',
            'promotion_create',
            'promotion_update',
            'promotion_broadcast',
        ];
    }
}
