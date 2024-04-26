<?php

namespace App\Services\Files;

use App\Contracts\FileUploadContract;
use claviska\SimpleImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageUploadService extends ImageConfigs implements FileUploadContract
{
    public static string $fileName = '';

    public static function upload(UploadedFile $file): static
    {
        $image = new SimpleImage;

        static::$fileName = Str::random(16) . '.webp';

        $image->fromFile($file);

        if (!static::$constrained) {
            $image->autoOrient()
                ->resize(static::$width, static::$height);
        }

        $image->toFile(static::collectivePath(), 'image/webp', [
            'quality' => static::$quality ?? 100,
        ]);

        return new static;
    }

    public static function fileName(): string
    {
        return static::$fileName;
    }

    private static function collectivePath(): string
    {
        return static::$directory . DIRECTORY_SEPARATOR . static::$fileName;
    }
}
