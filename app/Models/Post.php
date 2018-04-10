<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $fillable = [
    	'title',
        'slug',
    	'body'
    ];

    public function getRouteKeyName()
	{
	    return 'slug';
	}

	public function images()
	{
		return $this->belongsToMany('App\Models\Image');
	}

	public function getCoverAttribute()
	{
		return optional($this->images)->first();
	}

	public function getSummaryAttribute()
	{
		return str_limit($this->body, 100);
	}
}
