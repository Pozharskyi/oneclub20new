<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Error 403 - Forbidden</title>
    <meta name="viewport" content="width=device-width">
    <style type="text/css">
        body { margin: 0; font-size: 1em; line-height: 1.4; }
        ::-moz-selection { background: #E37B52; color: #fff; text-shadow: none; }
        ::selection { background: #E37B52; color: #fff; text-shadow: none; }
        a { color: #00e; }
        a:visited { color: #551a8b; }
        a:hover { color: #06e; }
        a:focus { outline: thin dotted; }
        a:hover, a:active { outline: 0; }

        td { vertical-align: top; }
        body
        {
            font-family:'Droid Sans', sans-serif;
            font-size:10pt;
            color:#555;
            line-height: 25px;
        }
        .wrapper
        {
            width:760px;
            margin:0 auto 5em auto;
        }
        .main
        {
            overflow:hidden;
        }
        .error-spacer
        {
            height:4em;
        }
        a, a:visited
        {
            color:#2972A3;
        }
        a:hover
        {
            color:#72ADD4;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="error-spacer"></div>
    <div role="main" class="main">
        <h1>Отказано в доступе</h1>

        <h2>Server Error: 403 (Forbidden)</h2>

        <hr>

        <h3>Что это значит?</h3>

        <p>
            У вас нет прав доступа для просмотра этой страницы.
        </p>

        <p>
             <a href="{{ url('/') }}">Главная страница</a>
        </p>
        <p>
            <a href="{{ url('/admin') }}">Главная страница админ панели</a>
        </p>
        <p>
            <a href="{{ url()->previous() }}">Назад</a>
        </p>
    </div>
</div>
</body>
</html>