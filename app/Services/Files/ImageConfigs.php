<?php

namespace App\Services\Files;

class ImageConfigs
{
    public static string $directory = '';
    public static ?int $width = null;
    public static ?int $height = null;
    public static ?int $quality = null;
    public static bool $constrained = false;

    public static function setDirectory(string $directory): static
    {
        static::$directory = $directory;

        if (! is_dir($directory)) {
            mkdir($directory, recursive: true);
        }

        return new static;
    }

    /**
     * Set the image width and height.
     */
    public static function setSize(?int $width, ?int $height): static
    {
        static::$width = $width;
        static::$height = $height;

        return new static;
    }

    /**
     * Set the image quality.
     */
    public static function setQuality(int $quality = 80): static
    {
        static::$quality = $quality;

        return new static;
    }

    /**
     * Allow image to contain original size.
     */
    public static function constrained(): static
    {
        static::$constrained = true;

        return new static;
    }
}
