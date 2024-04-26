<?php

namespace App\Services\Writes;

use App\DTO\ImageDTO;
use App\Models\Image;

class ImageWriteService
{
    public function create(ImageDTO $imageDTO): Image
    {
        return Image::create([
            'title' => $imageDTO->title,
            'alt' => $imageDTO->alt,
            'src' => $imageDTO->src,
            'imageable_type' => $imageDTO->model::class,
            'imageable_id' => $imageDTO->modelId,
        ]);
    }
}
