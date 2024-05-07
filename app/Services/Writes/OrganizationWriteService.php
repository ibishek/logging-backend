<?php

namespace App\Services\Writes;

use App\DTO\ImageDTO;
use App\DTO\OrganizationDTO;
use App\Models\Organization;
use App\Models\OrganizationUser;
use Illuminate\Support\Facades\Auth;

class OrganizationWriteService
{
    /**
     * Create organization and save.
     */
    public function create(OrganizationDTO $organizationDTO): Organization
    {
        return Organization::create([
            'name' => $organizationDTO->name,
            'slug' => $organizationDTO->slug,
            'description' => $organizationDTO->description,
            'logo' => $organizationDTO->logo,
            'background_image' => $organizationDTO->backgroundImage,
            'weekend' => $organizationDTO->weekEnd,
            'work_time' => $organizationDTO->workTime,
            'break_time' => $organizationDTO->breakTime,
            'default_department_id' => $organizationDTO->defaultDepartmentId,
            'default_project_id' => $organizationDTO->defaultProjectId,
            'owner_id' => Auth::id(),
        ]);
    }

    /**
     * Update organization detail.
     */
    public function update(Organization $organization, OrganizationDTO $organizationDTO): Organization
    {
        $organization->name = $organizationDTO->name;
        $organization->description = $organizationDTO->description;
        $organization->weekend = $organizationDTO->weekEnd;
        $organization->work_time = $organizationDTO->workTime;
        $organization->break_time = $organizationDTO->breakTime;
        $organization->default_department_id = $organizationDTO->defaultDepartmentId;
        $organization->default_project_id = $organizationDTO->defaultProjectId;

        $organization->save();

        return $organization;
    }

    /**
     * Attach organization to the organization user.
     */
    public function attachToUser(int $organizationId, OrganizationUser $orgUser, bool $isDefault): void
    {
        $orgUser->organization_id = $organizationId;

        if ($isDefault) {
            $orgUser->is_default = 1;
        }

        $orgUser->save();
    }

    /**
     * Attach logo to the organization.
     */
    public function attachLogo(?string $src, Organization $organization): bool
    {
        if (! $src) {
            return false;
        }

        $imageDTO = new ImageDTO(
            null,
            $organization->name,
            $src,
            new Organization,
            $organization->id
        );

        $imageWriteService = new ImageWriteService;
        $image = $imageWriteService->create($imageDTO);

        $organization->logo = $image->id;

        return $organization->save();
    }

    /**
     * Attach background image to organization.
     */
    public function attachBackgroundImage(?string $src, Organization $organization): bool
    {
        if (! $src) {
            return false;
        }

        $imageDTO = new ImageDTO(
            null,
            $organization->name,
            $src,
            new Organization,
            $organization->id
        );

        $imageWriteService = new ImageWriteService;
        $image = $imageWriteService->create($imageDTO);

        $organization->background_image = $image->id;

        return $organization->save();
    }
}
