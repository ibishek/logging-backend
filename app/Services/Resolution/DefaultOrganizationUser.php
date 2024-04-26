<?php

namespace App\Services\Resolution;

use App\Models\OrganizationUser;
use Auth;

class DefaultOrganizationUser
{
    /**
     * Get the organization that the user has set as default one.
     */
    public function get(): OrganizationUser
    {
        return once(function () {
            return OrganizationUser::query()
                ->where('user_id', Auth::id())
                ->where('is_default', 1)
                ->first();
        });
    }
}
