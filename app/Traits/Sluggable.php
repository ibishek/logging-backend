<?php

namespace App\Traits;

use Str;

trait Sluggable
{
    /**
     * Generate unique slug for the model.
     */
    public static function getSlug(string ...$args): string
    {
        $slugColumn = (new self)->slugColumn ?? 'slug';

        $slug = strtolower(implode('-', str_replace(' ', '-', $args)));

        $hasUniqueSlug = 1;

        while ($hasUniqueSlug) {
            $hasUniqueSlug = static::where($slugColumn, $slug)->count();

            if ($hasUniqueSlug) {
                $slug .= '-' . Str::random(6);
            }
        }

        return $slug;
    }
}
