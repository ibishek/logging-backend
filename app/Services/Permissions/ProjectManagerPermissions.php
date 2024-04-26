<?php

namespace App\Services\Permissions;

use App\Contracts\UserPermissionContract;

class ProjectManagerPermissions implements UserPermissionContract
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
            'department_create',
            'department_update',
            'leave_create',
            'leave_update',
            'leave_delete',
            'leave_approve',
        ];
    }
}
