<link rel="stylesheet" type="text/css" href="{{ url('/css/admin/import/sub-nav.css') }}" />

<div class="container">
    <div class="row">
        <ul id="nav">
            <li>
                <a href="{{ url('/admin/import/parties') }}">Просмотр товарных партий</a>
            </li>
            <li>
                <a href="{{ url('/admin/import/parties/search') }}">Поиск по товарным партиям</a>
            </li>
            <li>
                <a href="{{ url('/admin/import/parties/create') }}">Добавить товарную партию</a>
            </li>
            <li>
                <a href="{{ url('/admin/import/parties/stats') }}">Статистика</a>
            </li>
        </ul>

        <div class="divider"></div>

    </div>
</div>