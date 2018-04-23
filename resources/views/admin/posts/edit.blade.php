@extends('admin.layouts.app')

@section('title', 'Edit post')

@section('content')

    <h3>Edit post <a class="btn btn-info" href="{{ route('post.show', $post) }}" role="button">View post</a></h3>

    {!! Form::model($post, ['route' => ['admin.post.update', $post], 'method' => 'put', 'files' => true]) !!}

        <div class="row">

            <div class="col-7">
                <div class="form-group">
                    <label for="title">Title</label>

                    {!! Form::text('title', null, ['id' => 'title', 'name' => 'title', 'placeholder' => 'Enter a title', 'class' => 'form-control']); !!}
                </div>

                <div class="form-group">
                    <label for="body">Body</label>

                    {!! Form::textarea('body', null, ['id' => 'body', 'name' => 'body', 'class' => 'form-control']); !!}
                </div>

            </div>

            <div class="col-sm">

                <div class="form-group">
                    <label for="image">Image</label>

                    <input type="file" class="form-control-file" id="image_file" name="image">
                </div>

                <div class="form-group">
                    <label for="title">Alternative text for image</label>

                    {!! Form::text('image_alt', null, ['id' => 'image_alt', 'name' => 'image_alt', 'placeholder' => 'Enter an alternative text', 'class' => 'form-control']); !!}
                </div>

                @if($post->image_file)
                    <p><img src="{{ $post->getImageSrc('l') }}" alt="{{ $post->image_file }}"></p>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="yes" id="delete_image" name="delete_image">
                        <label class="form-check-label" for="delete_image">Delete image</label>
                    </div>
                @endif

                <p class="text-right mt-3"><button type="submit" class="btn btn-primary">Update post</button></p>

            </div>

        </div>

    {!! Form::close() !!}

    @if(!$post->deleted_at)
        {!! Form::open(['route' => ['admin.post.destroy', $post], 'method' => 'delete']) !!}
            <p><button type="submit" class="btn btn-danger">Delete post</button></p>
        {!! Form::close() !!}
    @else   
        {!! Form::open(['route' => ['admin.post.restore', $post], 'method' => 'put']) !!}
            <p><button type="submit" class="btn btn-secondary">Restore post</button></p>
        {!! Form::close() !!}
    @endif

@endsection

@section('scripts')

    <script src="{{ url('ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace( 'body', {
            height: 400
        } );
    </script>

@endsection