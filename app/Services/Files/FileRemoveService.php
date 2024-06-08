<?php

namespace App\Services\Files;

use Illuminate\Support\Facades\Storage;

class FileRemoveService
{
    public static function remove(string $src): bool
    {
        if (! file_exists($src)) {
            return false;
        }

        return Storage::delete($src);
    }
}
