@extends('layouts.import')

@section('title') Страница управления импортом Oneclub2.0 @stop

@section('content')

    <div class="dropup">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Управление импортом
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2" id="importMenu">
            <li><a href="{{ url('#tp_creation') }}">Создание товарной партии</a></li>
            <li><a href="{{ url('#tp_edition') }}">Редактирование товарной партии</a></li>
            <li><a href="{{ url('#tp_deletion') }}">Удаление товарной партии</a></li>
            <li><a href="{{ url('#uploading') }}">Загрузка списка</a></li>
            <li><a href="{{ url('#ta_creation') }}">Создание товарной акции</a></li>
            <li><a href="{{ url('#linking') }}">Привязка ТП к ТА</a></li>
            <li><a href="{{ url('#exporting') }}">Выгрузка файла в Excel</a></li>
            <li><a href="{{ url('#updating') }}">Обновление цен и остатков</a></li>
            <li class="none_found">
                <a class="none_found" href="#">Результатов не найдено</a>
            </li>
            <li role="separator" class="divider"></li>
            <li>
                <input type="text" placeholder="Search.." id="search" onkeyup="filterFunction()">
            </li>
        </ul>
    </div>

@endsection