<?php

namespace App\Traits\Eloquent;

use App\Models\Image;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasLogoAndBackgroundImage
{
    /**
     * Get the attached logo from the image model.
     *
     * @return Attribute<Image, int>
     */
    protected function logo(): Attribute
    {
        return Attribute::make(
            get: function ($logo) {
                if (! $logo) {
                    return null;
                }

                return Image::query()
                    ->where('imageable_id', $logo)
                    ->where('imageable_type', self::class)
                    ->first();
            },
            set: function ($logo) {
                return $logo;
            }
        )->shouldCache();
    }

    /**
     * Get the attached background image from the image model.
     *
     * @return Attribute<Image, int>
     */
    protected function backgroundImage(): Attribute
    {
        return Attribute::make(
            get: function ($backgroundImage) {
                if (! $backgroundImage) {
                    return null;
                }

                return Image::query()
                    ->where('imageable_id', $backgroundImage)
                    ->where('imageable_type', self::class)
                    ->first();
            },
            set: function ($backgroundImage) {
                return $backgroundImage;
            }
        )->shouldCache();
    }
}
