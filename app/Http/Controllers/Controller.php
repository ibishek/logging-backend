<?php

namespace App\Http\Controllers;

use App\Models\OrganizationUser;
use App\Models\SiteAdmin;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Check whether model has given permission.
     */
    public function checkPermission(OrganizationUser|SiteAdmin $user, string $permission, ?string $message = null): true|JsonResponse
    {
        if ($user->hasPermissionTo($permission)) {
            return true;
        }

        if ($message) {
            return response()->forbidden($message);
        }

        $message = 'You don\'t have sufficient permission to ' . str_replace(['update', '_'], ['edit', ' '], $permission);

        return response()->forbidden($message);
    }
}
