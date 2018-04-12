<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['slug'] = str_slug($data['title']);

        $post = Post::create($data);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $name = basename($request->image->store('img'));

            $image = Image::create(['file' => $name]);

            $post->images()->save($image);
        }

        return redirect()->route('admin.post.index')
                         ->with('success', 'Post successfully created!');
    }
}
