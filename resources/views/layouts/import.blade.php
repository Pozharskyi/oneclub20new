<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @yield('title')
        </title>

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('/css/admin/import/main.css') }}" />

        <!-- Scripts -->
        <script type="text/javascript" src="{{ url('/js/token.js') }}"></script>
        <script type="text/javascript" src="{{ url('/js/jquery-3.1.0.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('/js/admin/import/main.js') }}"></script>
        <script type="text/javascript" src="{{ url('/js/bootstrap_min.js') }}"></script>
        <script type="text/javascript" src="{{ url('/js/admin/import/control.js') }}"></script>
    </head>
    <body>

        @yield('content')

    </body>
</html>