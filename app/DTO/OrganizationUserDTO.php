<?php

namespace App\DTO;

class OrganizationUserDTO
{
    public function __construct(
        public ?string $displayName,
        public ?string $designation,
        public bool $isDefault,
        public ?string $organizationUserId,
        public int $userId,
        public int $organizationId
    ) {
    }
}
