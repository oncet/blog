@extends('layouts.app')

@section('title', 'Homepage')

@section('content')

    <div class="row">

        <div class="col-9">

            @foreach ($posts as $post)
                <div class="post">
                    <div class="date" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</div>

                    <h2><a href="{{ route('post.show', ['slug' => $post->slug]) }}">{{ $post->title }}</a></h2>

                    @if ($post->image_file)
                        <div class="mt-3 mb-3">
                            <a href="{{ route('post.show', ['slug' => $post->slug]) }}"><img src="{{ $post->getImageSrc() }}" alt="{{ $post->image_alt }}"></a>
                        </div>
                    @endif

                    <div class="summary">
                        {!! $post->summary !!}
                    </div>

                    <hr>
                </div>
            @endforeach

            {{ $posts->links() }}

        </div>

        <div class="col">
            <h4>About</h4>
            <p>Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum.</p>
            <hr>
            <h4>Tags</h4>
            <p><a class="btn btn-light btn-sm" href="#" role="button">Printing</a> <a class="btn btn-light btn-sm" href="#" role="button">Textiles</a> <a class="btn btn-light btn-sm" href="#" role="button">Bookbinding</a></p>
        </div>
    </div>

@endsection