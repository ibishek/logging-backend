<?php

namespace App\Models;

use App\Traits\Eloquent\HasLogoAndBackgroundImage;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Organization extends Model
{
    use HasFactory, HasLogoAndBackgroundImage, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'background_image',
        'weekend',
        'work_time',
        'break_time',
        'default_department_id',
        'default_project_id',
        'owner_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'weekend' => 'json',
        ];
    }

    /**
     * Get the user that owns the organization.
     *
     * @return BelongsTo<User, Organization>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'owner_id');
    }

    /**
     * Get the organization user associated with the organization.
     *
     * @return HasMany<OrganizationUser>
     */
    public function organizationUsers(): HasMany
    {
        return $this->hasMany(OrganizationUser::class);
    }

    /**
     * Get the departments associated with the organization.
     *
     * @return HasMany<Department>
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get the projects associated with the organization.
     *
     * @return HasMany<Project>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the default department associated with the organization.
     *
     * @return HasOne<Department>
     */
    public function defaultDepartment(): HasOne
    {
        return $this->hasOne(Department::class, 'id', 'default_department_id');
    }

    /**
     * Get the default project associated with the organization.
     *
     * @return HasOne<Project>
     */
    public function defaultProject(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'default_project_id');
    }

    /**
     * Get the leaves types associated with the organization.
     *
     * @return HasMany<LeaveType>
     */
    public function leaves(): HasMany
    {
        return $this->hasMany(LeaveType::class)
            ->orWhereNull('organization_id');
    }

    /**
     * Get the leave duration types associated with the organization.
     *
     * @return HasMany<LeaveDurationType>
     */
    public function leaveDuration(): HasMany
    {
        return $this->hasMany(LeaveDurationType::class)
            ->orWhereNull('organization_id');
    }
}
