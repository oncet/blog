<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public $fillable = [
    	'title',
        'slug',
        'body',
        'image_file',
        'image_alt'
    ];

    public function getRouteKeyName()
	{
	    return 'slug';
	}

	public function images()
	{
		return $this->belongsToMany('App\Models\Image');
	}

	public function getImageAttribute()
	{
		return optional($this->images)->first();
	}

	public function getSummaryAttribute()
	{
		return str_limit($this->body, 100);
	}

    public function getImageSrc($template = 'xl')
    {
        return route('imagecache', ['template' => $template, 'filename' => $this->image_file]);
    }
}
