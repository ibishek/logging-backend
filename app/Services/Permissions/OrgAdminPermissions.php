<?php

namespace App\Services\Permissions;

use App\Contracts\UserPermissionContract;

class OrgAdminPermissions implements UserPermissionContract
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
            'project_delete',
            'project_assign',
            'project_status',
            'project_created_approve',
            'project_updated_approve',
            'department_create',
            'department_update',
            'department_delete',
            'department_assign',
            'department_created_approve',
            'department_updated_approve',
            'user_create',
            'user_update',
            'user_disable',
            'user_delete',
            'leave_create',
            'leave_update',
            'leave_delete'
        ];
    }
}
