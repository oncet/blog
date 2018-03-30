<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Posts</title>
  </head>
  <body>
    <div class="container mt-3">
      <h1>Posts</h1>

      @foreach ($posts as $post)
        <div class="post">
          <h2><a href="{{ route('photos.show', ['slug' => $post->slug]) }}">{{ $post->title }}</a></h2>
          <p>{{ $post->created_at->diffForHumans() }}</p>
          @if ($post->cover)
            <p><img src="{{ route('imagecache', ['template' => 'large', 'filename' => $post->cover->file]) }}" alt="{{ $post->cover->alt }}"></p>
          @endif
          <div class="summary">
            {!! $post->summary !!}
          </div>
        </div>
      @endforeach
    </div>
  </body>
</html>