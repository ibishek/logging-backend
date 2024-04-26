<?php

namespace App\Services\Permissions;

use App\Contracts\UserPermissionContract;

class SupervisorPermissions implements UserPermissionContract
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
            'log_authorize',
            'log_reaction',
            'project_create',
            'project_update',
            'project_status',
            'leave_create',
            'leave_update',
            'leave_delete',
            'leave_approve',
        ];
    }
}
