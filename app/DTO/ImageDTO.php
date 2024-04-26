<?php

namespace App\DTO;

use Illuminate\Database\Eloquent\Model;

class ImageDTO
{
    public function __construct(
        public ?string $title,
        public ?string $alt,
        public string $src,
        public Model $model,
        public int $modelId
    ) {
    }
}
