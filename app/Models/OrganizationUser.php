<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class OrganizationUser extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'display_name',
        'designation',
        'is_default',
        'organization_user_id',
        'user_id',
        'organization_id',
    ];

    protected string $guard_name = 'api';

    /**
     * Get the user that owns the organization user.
     *
     * @return BelongsTo<User, OrganizationUser>|null
     */
    public function user(): ?BelongsTo
    {
        if ($this->user_id) {
            return $this->belongsTo(User::class)->withDefault([
                'first_name' => 'Someone',
                'last_name' => 'from organization',
                'email' => 'someone@loggi.ng',
            ]);
        }

        return null;
    }

    /**
     * Get the organization that owns the organization user.
     *
     * @return BelongsTo<Organization, OrganizationUser>|null
     */
    public function organization(): ?BelongsTo
    {
        if ($this->organization_id) {
            return $this->belongsTo(Organization::class);
        }

        return null;
    }

    /**
     * Get the organization user's full display name.
     *
     * @return Attribute<string, never>
     */
    public function displayName(): Attribute
    {
        return Attribute::make(get: function (?string $value) {
            if ($value) {
                return $value;
            }

            return $this->user()?->full_name;
        });
    }
}
