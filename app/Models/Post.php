<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use SoftDeletes;

    public $fillable = [
    	'title',
        'slug',
        'body',
        'draft',
        'image_file',
        'image_alt'
    ];

    public function getRouteKeyName()
	{
	    return 'slug';
	}

	public function getSummaryAttribute()
	{
		return str_limit($this->body, 100);
	}

    public function getDraftTextAttribute()
    {
        return $this->draft? 'Yes' : 'No';
    }

    public function gatImageFilePathAttribute()
    {
        if($this->image_file) {
            return 'img/' . $this->image_file;
        }

        return null;
    }

    public function getImageSrc($template = 'xl')
    {
        return route('imagecache', ['template' => $template, 'filename' => $this->image_file]);
    }

    public function deleteImageFile()
    {
        if (Storage::exists($this->image_file_path)) {
            Storage::delete($this->image_file_path);
        }
    }
}
