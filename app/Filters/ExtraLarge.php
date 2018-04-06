<?php

namespace App\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ExtraLarge implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(1920, 1080)->encode(null, 80);
    }
}