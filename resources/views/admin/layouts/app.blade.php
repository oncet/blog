<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

        <title>@yield('title') - {{ config('app.name') }} administration</title>

        <style type="text/css">
            img {
                max-width: 100%;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ route('post.index') }}">{{ config('app.name') }}</a>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.post.index') }}">View posts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.post.create') }}">Create post</a>
              </li>
            </ul>
        </nav>

        <div class="container mt-3">
            @yield('content')
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        @yield('scripts')
    </body>
</html>