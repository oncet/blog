@extends('layouts.app')

@section('title', 'Posts')

@section('content')

  <h1>Posts</h1>

  @foreach ($posts as $post)
    <div class="post">
      <h2><a href="{{ route('photos.show', ['slug' => $post->slug]) }}">{{ $post->title }}</a></h2>
      <p>{{ $post->created_at->diffForHumans() }}</p>
      @if ($post->cover)
        <p><a href="{{ route('photos.show', ['slug' => $post->slug]) }}"><img src="{{ route('imagecache', ['template' => 'large', 'filename' => $post->cover->file]) }}" alt="{{ $post->cover->alt }}"></a></p>
      @endif
      <div class="summary">
        {!! $post->summary !!}
      </div>
    </div>
  @endforeach

@endsection