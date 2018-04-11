@extends('layouts.app')

@section('title', 'Create a new post')

@section('content')

    {!! Form::open(['route' => 'admin.post.store']) !!}
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter a title">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea class="form-control" id="body" name="body" rows="10"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create post</button>
    {!! Form::close() !!}

@endsection