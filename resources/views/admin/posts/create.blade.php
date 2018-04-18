@extends('admin.layouts.app')

@section('title', 'Create a new post')

@section('content')

    {!! Form::open(['route' => 'admin.post.store', 'files' => true]) !!}

        <div class="form-group">
            <label for="title">Title</label>

            {!! Form::text('title', null, ['id' => 'title', 'name' => 'title', 'placeholder' => 'Enter a title', 'class' => 'form-control']); !!}
        </div>

        <div class="form-group">
            <label for="image">Image</label>

            <input type="file" class="form-control-file" id="image" name="image">
        </div>

        <div class="form-group">
            <label for="title">Alternative text for image</label>

            {!! Form::text('image_alt', null, ['id' => 'image_alt', 'name' => 'image_alt', 'placeholder' => 'Enter an alternative text', 'class' => 'form-control']); !!}
        </div>

        <div class="form-group">
            <label for="body">Body</label>

            {!! Form::textarea('body', null, ['id' => 'body', 'name' => 'body', 'class' => 'form-control']); !!}
        </div>

        <button type="submit" class="btn btn-primary">Create post</button>

    {!! Form::close() !!}

@endsection

@section('scripts')

    <script src="{{ url('ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace( 'body', {
            height: 500
        } );
    </script>

@endsection