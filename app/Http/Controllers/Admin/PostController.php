<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->withTrashed()->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['slug'] = str_slug($data['title']);

        $post = Post::create($data);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $name = basename($request->image->store('img'));

            $post->image_file = $name;

            $post->save();
        }

        return redirect()->route('admin.post.index')
                         ->with('success', 'Post successfully created!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Post $post, Request $request)
    {
        $post->fill($request->all());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $name = basename($request->image->store('img'));

            if ($post->image_file) {
                Storage::delete('img/' . $post->image_file);
            }

            $post->image_file = $name;

        } elseif ($request->input('delete_image') == 'yes') {

            Storage::delete('img/' . $post->image_file);

            $post->image_file = null;
        }

        $post->save();

        return redirect()->route('admin.post.index')
                 ->with('success', 'Post successfully updated!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.post.index')
                         ->with('success', 'Post successfully deleted!');
    }

    public function restore(Post $trashed_post)
    {
        $trashed_post->restore();

        return redirect()->route('admin.post.index')
                         ->with('success', 'Post successfully restored!');
    }
}
