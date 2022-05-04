<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>Chat</title>
</head>
<body>
    <div id="app">
        <chat-list :user-from-blade="{{ Auth::user() }}"></chat-list>
    </div>
</body>
</html>
