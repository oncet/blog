@extends('admin.layouts.app')

@section('title', 'Posts')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3>Posts list</h3>

    <table id="posts" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Draft</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Deleted</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr class="@if($post->deleted_at) table-danger @elseif($post->draft) table-info @endif">
                    <td>{{ $post->id }}</td>
                    <td><a href="{{ route('admin.post.edit', $post->slug) }}">{{ $post->title }}</a></td>
                    <td>{{ $post->draft_text }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td>{{ $post->updated_at }}</td>
                    <td>{{ $post->deleted_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@section('scripts')

    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

    <script>
        $(document).ready( function () {
            $('#posts').DataTable({
                "order": [[ 0, "desc" ]]
            });
        } );
    </script>

@endsection