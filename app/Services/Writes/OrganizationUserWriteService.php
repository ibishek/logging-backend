<?php

namespace App\Services\Writes;

use App\DTO\OrganizationUserDTO;
use App\Models\OrganizationUser;

class OrganizationUserWriteService
{
    public function create(OrganizationUserDTO $organizationUserDTO): OrganizationUser
    {
        return OrganizationUser::create([
            'display_name' => $organizationUserDTO->displayName,
            'designation' => $organizationUserDTO->designation,
            'is_default' => $organizationUserDTO->isDefault,
            'organization_user_id' => $organizationUserDTO->organizationUserId,
            'user_id' => $organizationUserDTO->userId,
            'organization_id' => $organizationUserDTO->organizationId,
        ]);
    }

    public function revokeSetAsDefault(int $userId): void
    {
        OrganizationUser::query()
            ->where('user_id', $userId)
            ->where('is_default', 1)
            ->update(['is_default' => 0]);
    }
}
