@extends('layouts.app')

@section('title', 'Create a new post')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

@endsection