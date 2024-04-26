<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveType extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'organization_id',
    ];

    /**
     * Get the organization that owns the leave type.
     *
     * @return BelongsTo<Organization, LeaveType>|null
     */
    public function organization(): ?BelongsTo
    {
        if ($this->organization_id) {
            return $this->belongsTo(Organization::class);
        }

        return null;
    }
}
