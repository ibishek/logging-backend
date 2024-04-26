<?php

namespace App\Models;

use App\Traits\Eloquent\HasLogoAndBackgroundImage;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory, HasLogoAndBackgroundImage, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'logo',
        'background_image',
        'status',
        'enable_log_title',
        'created_by',
        'approved_by',
        'organization_id',
    ];

    /**
     * Get the department that owns the project.
     *
     * @return HasOne<Department>
     */
    public function department(): HasOne
    {
        return $this->hasOne(Department::class);
    }

    /**
     * Get the organization that owns the project.
     *
     * @return BelongsTo<Organization, Project>
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the associated users through project user.
     *
     * @return HasManyThrough<OrganizationUser>
     */
    public function organizationUsers(): HasManyThrough
    {
        return $this->hasManyThrough(OrganizationUser::class, ProjectUser::class);
    }
}
