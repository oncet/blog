@extends('admin.layouts.app')

@section('title', 'Posts')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

@endsection