<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="/js/jquery-3.1.0.min.js"></script>

</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/admin') }}">
                Oneclub2.0
            </a>
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="{{ url('/admin/import/') }}">Импорт товаров</a>
                </li>
                <li>
                    <a href="{{ url('/admin/notifications/') }}">Уведомления</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Дополнительно<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ url('/admin/search') }}">Поиск пользователя</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/products') }}">Список продуктов</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/discounts/create') }}">Создание дискаунтов</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin') }}">Статистика</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Управление каталогом<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ url('/admin/manage/brands') }}">Бренды</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/manage/colors') }}">Цвета</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/manage/sizes') }}">Размеры</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/manage/categories') }}">Категории</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/manage/size_chart') }}">Размерные сетки</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/manage/roles') }}">Роли</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Магазин<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ url('/list') }}">Каталог</a>
                        </li>
                        <li>
                            <a href="{{ url('/sale') }}">% Скидки</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Отделы<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ url('/admin/departments/content') }}">Контент</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/departments/photography') }}">Фотосьемка</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Здравствуйте, Пользователь <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class='container-fluid'>
    {{--<div class='row'>--}}
        <ul class="breadcrumb">
            @yield('breadcrumb')
        </ul>
        @yield('content')
    {{--</div>--}}
</div>
<!-- Scripts -->
<script src="/js/app.js"></script>
<script src="/js/jquery-3.1.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
</script>
</body>
</html>
