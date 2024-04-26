<?php

namespace App\Models;

use App\Traits\Eloquent\HasLogoAndBackgroundImage;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Department extends Model
{
    use HasFactory, HasLogoAndBackgroundImage, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'logo',
        'background_image',
        'status',
        'created_by',
        'approved_by',
        'organization_id',
    ];

    /**
     * Get the organization that owns the department.
     *
     * @return BelongsTo<Organization, Department>
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the associated users through department user.
     *
     * @return HasManyThrough<OrganizationUser>
     */
    public function organizationUsers(): HasManyThrough
    {
        return $this->hasManyThrough(OrganizationUser::class, DepartmentUser::class);
    }

    /**
     * Get the projects associated with the departments.
     *
     * @return HasMany<Project>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
