<?php

namespace App\DTO;

use App\Models\Organization;

class OrganizationDTO
{
    public string $slug = '';
    public ?string $weekEnd = null;

    /**
     * @param  null|array<string>  $weekEnd
     */
    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $logo,
        public ?string $backgroundImage,
        ?array $weekEnd,
        public string $workTime,
        public string $breakTime,
        public ?int $defaultDepartmentId,
        public ?int $defaultProjectId
    ) {
        $this->slug = Organization::getSlug($this->name);
        if ($weekEnd) {
            $this->weekEnd = (string) json_encode($weekEnd);
        }
    }
}
