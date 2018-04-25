<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $public_post)
    {
        return view('posts.show', ['post' => $public_post]);
    }

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->where('draft', false)->paginate(4);

        return view('posts.index', compact('posts'));
    }
}
