<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationalLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'on',
        'status',
        'organization_id',
        'created_by',
        'leave_type_id',
        'leave_duration_type_id',
    ];

    /**
     * Get the organization that owns the organizational leave.
     *
     * @return BelongsTo<Organization, OrganizationalLeave>
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the user that owns the organizational leave.
     *
     * @return BelongsTo<User, OrganizationalLeave>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the leave type that owns the organizational leave.
     *
     * @return BelongsTo<LeaveType, OrganizationalLeave>
     */
    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }

    /**
     * Get the leave duration type that owns the organizational leave.
     *
     * @return BelongsTo<LeaveDurationType, OrganizationalLeave>
     */
    public function leaveDurationType(): BelongsTo
    {
        return $this->belongsTo(LeaveDurationType::class);
    }
}
