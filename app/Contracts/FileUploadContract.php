<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;
use Throwable;

interface FileUploadContract
{
    /**
     * Set the directory file should be uploaded to.
     */
    public static function setDirectory(string $directory): static;

    /**
     * Method to upload file.
     */
    public static function upload(UploadedFile $file): bool|static|Throwable;

    /**
     * Get the modified file name.
     */
    public static function fileName(): string;
}
