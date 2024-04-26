<?php

namespace Tests\Feature;

use App\Enums\FilePath;
use App\Services\Files\ImageUploadService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageUploadTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function resize_and_upload(): void
    {
        $isUploaded = ImageUploadService::setDirectory(public_path('storage' . DIRECTORY_SEPARATOR . FilePath::ORGANIZATION->value))
            ->setSize(150, 200)
            ->setQuality(90)
            ->upload(UploadedFile::fake()->image(680, 680));

        $this->assertTrue($isUploaded);
    }

    /**
     * @test
     */
    public function original_size(): void
    {
        $isUploaded = ImageUploadService::setDirectory(public_path('storage' . DIRECTORY_SEPARATOR . FilePath::ORGANIZATION->value))
            ->constrained()
            ->setQuality(90)
            ->upload(UploadedFile::fake()->image(680, 680));

        $this->assertTrue($isUploaded);
    }
}
