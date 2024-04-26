<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'alt',
        'src',
        'imageable_id',
        'imageable_type',
    ];

    /**
     * Get the image attached to parent models.
     *
     * @return MorphTo<Model, Image>
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
