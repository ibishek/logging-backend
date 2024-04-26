<?php

namespace App\Services\Permissions;

use App\Contracts\UserPermissionContract;

class SubordinatePermissions implements UserPermissionContract
{
    /**
     * {@inheritDoc}
     */
    public static function permissions(): array
    {
        return [
            'log_create',
            'log_update',
            'log_delete',
            'project_status',
            'leave_create',
            'leave_update',
            'leave_delete',
        ];
    }
}
