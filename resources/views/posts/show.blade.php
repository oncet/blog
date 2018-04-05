@extends('layouts.app')

@section('title', $post->title)

@section('content')

  <h2>{{ $post->title }}</h2>

  <p>{{ $post->created_at->diffForHumans() }}</p>

  @if ($post->cover)
    <p><img src="{{ route('imagecache', ['template' => 'large', 'filename' => $post->cover->file]) }}"></p>
  @endif

  {!! $post->body !!}

@endsection