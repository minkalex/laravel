<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>@yield('title')</title>
</head>
<body class="container mt-5">
<div class="content w-100 mb-5">
    <div id="app">
        <public-header
            :data="{{ json_encode(['user' => Auth::user(), 'routes' => ['main' => route('main'), 'profile' => route('profile'), 'logout' => route('logout')]]) }}"></public-header>
    </div>
    @yield('content')
</div>
</body>
</html>
