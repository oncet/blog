<h1>{{ $post->title }}</h1>

<p>{{ $post->created_at }}</p>

@if ($post->cover)
	<img src="{{ route('imagecache', ['template' => 'large', 'filename' => $post->cover]) }}">
@endif

{!! $post->body !!}