<?php

namespace App\DTO;

use App\Models\Organization;

class OrganizationDTO
{
    public string $slug;
    public string $weekEnd;

    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $logo,
        public ?string $backgroundImage,
        ?array $weekEnd,
        public string $workTime,
        public string $breakTime,
        public ?string $defaultDepartmentId,
        public ?string $defaultProjectId
    ) {
        $this->slug = Organization::getSlug($this->name);
        $this->weekEnd = json_encode($weekEnd);
    }
}
