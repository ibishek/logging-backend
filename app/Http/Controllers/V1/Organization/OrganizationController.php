<?php

namespace App\Http\Controllers\V1\Organization;

use App\DTO\OrganizationDTO;
use App\DTO\OrganizationUserDTO;
use App\Enums\FilePath;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Organization\StoreRequest;
use App\Http\Requests\V1\Organization\UpdateBackgroundLogoRequest;
use App\Http\Requests\V1\Organization\UpdateLogoRequest;
use App\Http\Requests\V1\Organization\UpdateRequest;
use App\Models\Organization;
use App\Services\Files\FileRemoveService;
use App\Services\Files\ImageUploadService;
use App\Services\Writes\OrganizationUserWriteService;
use App\Services\Writes\OrganizationWriteService;
use Auth;
use DB;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    public function __construct(
        public OrganizationWriteService $organizationWriteService,
        public OrganizationUserWriteService $organizationUserWriteService
    ) {
    }

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $logo = null;
            $backgroundLogo = null;

            if ($request->hasFile('logo')) {
                $logo = ImageUploadService::setDirectory(public_path('storage' . DIRECTORY_SEPARATOR . FilePath::ORGANIZATION->value))
                    ->setSize(config('backend-logging.image.logo.width'), config('backend-logging.image.logo.height'))
                    ->setQuality(config('backend-logging.image.quality'))
                    ->upload($request->file('logo'))
                    ->fileName();
            }

            if ($request->hasFile('background_image')) {
                $backgroundLogo = ImageUploadService::setDirectory(public_path('storage' . DIRECTORY_SEPARATOR . FilePath::ORGANIZATION->value))
                    ->setSize(config('backend-logging.image.background.width'), config('backend-logging.image.background.height'))
                    ->setQuality(config('backend-logging.image.quality'))
                    ->upload($request->file('background_image'))
                    ->fileName();
            }

            $organizationDTO = new OrganizationDTO(
                $request->name,
                $request?->description,
                null,
                null,
                $request?->week_end,
                $request->work_time,
                $request->break_time,
                $request?->default_department_id,
                $request?->default_project_id
            );

            $organization = $this->organizationWriteService->create($organizationDTO);
            $this->organizationWriteService->attachLogo($logo, $organization);
            $this->organizationWriteService->attachBackgroundImage($backgroundLogo, $organization);

            $organizationUserDTO = new OrganizationUserDTO(
                null,
                null,
                $request->set_default,
                null,
                Auth::id(),
                $organization->id
            );

            if ($request->set_default) {
                $this->organizationUserWriteService->revokeSetAsDefault(Auth::id());
            }

            $organizationUser = $this->organizationUserWriteService->create($organizationUserDTO);
            $organizationUser->assignRole(UserRole::ORG_ADMIN->value);

            DB::commit();

            return response()->created('Organization created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->error('Unable to create organization.');
        }
    }

    public function update(string $slug, UpdateRequest $request): JsonResponse
    {
        $organization = Organization::query()
            ->where('slug', $slug)
            ->where('owner_id', Auth::id())
            ->first();

        if (!$organization) {
            return response()->notFound('The organization you are looking for is not found.');
        }

        $organizationDTO = new OrganizationDTO(
            $request->name,
            $request?->description,
            null,
            null,
            $request?->week_end,
            $request->work_time,
            $request->break_time,
            $request?->default_department_id,
            $request?->default_project_id
        );

        $this->organizationWriteService->update($organization, $organizationDTO);

        return response()->success('Organization edited successfully.');
    }

    public function logo(string $slug, UpdateLogoRequest $request): JsonResponse
    {
        $organization = Organization::query()
            ->where('slug', $slug)
            ->where('owner_id', Auth::id())
            ->first();

        if (!$organization) {
            return response()->notFound('The organization you are looking for is not found.');
        }

        $logo = ImageUploadService::setDirectory(public_path('storage' . DIRECTORY_SEPARATOR . FilePath::ORGANIZATION->value))
            ->setSize(config('backend-logging.image.logo.width'), config('backend-logging.image.logo.height'))
            ->setQuality(config('backend-logging.image.quality'))
            ->upload($request->file('logo'))
            ->fileName();

        if ($organization->logo) {
            FileRemoveService::remove(public_path('storage' . DIRECTORY_SEPARATOR . FilePath::ORGANIZATION->value . DIRECTORY_SEPARATOR . $organization->logo));
        }

        $this->organizationWriteService->attachLogo($logo, $organization);

        return response()->success('The logo uploaded successfully.');
    }

    public function backgroundImage(string $slug, UpdateBackgroundLogoRequest $request): JsonResponse
    {
        $organization = Organization::query()
            ->where('slug', $slug)
            ->where('owner_id', Auth::id())
            ->first();

        if (!$organization) {
            return response()->notFound('The organization you are looking for is not found.');
        }

        $backgroundLogo = ImageUploadService::setDirectory(public_path('storage' . DIRECTORY_SEPARATOR . FilePath::ORGANIZATION->value))
            ->setSize(config('backend-logging.image.background.width'), config('backend-logging.image.background.height'))
            ->setQuality(config('backend-logging.image.quality'))
            ->upload($request->file('background_image'))
            ->fileName();

        if ($organization->backgroundLogo) {
            FileRemoveService::remove(public_path('storage' . DIRECTORY_SEPARATOR . FilePath::ORGANIZATION->value . DIRECTORY_SEPARATOR . $organization->backgroundLogo));
        }

        $this->organizationWriteService->attachBackgroundImage($backgroundLogo, $organization);

        return response()->success('The logo uploaded successfully.');
    }
}
