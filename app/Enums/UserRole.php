<?php

namespace App\Enums;

enum UserRole: string
{
    case APP_ADMIN = 'app_admin'; // Grant directly
    case ORG_ADMIN = 'org_admin';
    case PROJECT_MANAGER = 'project_manager';
    case SUPERVISOR = 'supervisor';
    case SUBORDINATE = 'subordinate';
    case UNASSIGNED = 'unassigned'; // When user gets deleted and email is not verified

    /**
     * Available roles.
     *
     * @return array<string>
     */
    public static function roles(): array
    {
        return array_map(fn (UserRole $case) => $case->value, self::cases());
    }

    /**
     * Assignable roles.
     *
     * @return array<string>
     */
    public static function assignable(): array
    {
        return array_map(function (UserRole $case) {
            if (! in_array($case->value, [static::APP_ADMIN->value, static::UNASSIGNED->value])) {
                return $case->value;
            }
        }, self::cases());
    }
}
