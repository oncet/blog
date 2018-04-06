<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function getSrcAttribute()
    {
        return route('imagecache', ['template' => 'xl', 'filename' => $this->file]);
    }
}
