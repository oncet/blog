@extends('layouts.app')

@section('title', config('app.name'))

@section('content')

    @foreach ($posts as $post)
        <div class="post">
            <div class="date" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</div>

            <h2><a href="{{ route('post.show', ['slug' => $post->slug]) }}">{{ $post->title }}</a></h2>

            @if ($post->cover)
                <div class="mt-3 mb-3"><a href="{{ route('post.show', ['slug' => $post->slug]) }}"><img src="{{ route('imagecache', ['template' => 'large', 'filename' => $post->cover->file]) }}" alt="{{ $post->cover->alt }}"></a></div>
            @endif

            <div class="summary">
                {!! $post->summary !!}
            </div>

            <hr>
        </div>
    @endforeach

    {{ $posts->links() }}

@endsection