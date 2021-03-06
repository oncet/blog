@extends('layouts.app')

@section('title', $post->title)

@section('content')

    <div class="date text-center" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</div>

    <h2 class="text-center">{{ $post->title }}</h2>

    @if ($post->image_file)
        <div id="post_image" class="mt-3 mb-3">
            <img src="{{ $post->getImageSrc() }}">
        </div>
    @endif

    {!! $post->body !!}

@endsection