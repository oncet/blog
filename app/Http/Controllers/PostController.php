<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(4);

        return view('posts.index', compact('posts'));
    }
}
