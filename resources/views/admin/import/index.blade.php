@extends('layouts.import')

@section('title') Страница управления импортом Oneclub2.0 @stop

@section('content')

    <div id="modal_form"><!-- Popup window -->
        <span id="modal_close" onclick="closePopup();">X</span> <!-- Close button -->
        <div id="popup_content"></div>
    </div>
    <div id="overlay"></div><!-- Overlay -->

    <div id="modal_form2"><!-- Popup window -->
        <div id="popup_content2"></div>
    </div>
    <div id="overlay2"></div><!-- Overlay -->

    <div id="modal_form3"><!-- Popup window -->
        <div id="popup_content3"></div>
    </div>
    <div id="overlay3"></div><!-- Overlay -->

    <div id="loading">
        <img src="{{ url('/images/import/loading.gif') }}" />
    </div>

    <div class="nav">
        <div class="pull-left">
            <ul id="nav">
                <li>
                    <a id="myParties" href="{{ url('#') }}">Мои ТП</a>
                </li>
                <li>
                    <a id="allParties" href="{{ url('#') }}">ТП</a>
                </li>
                <li>
                    <a id="allSales" href="{{ url('#') }}">ТА</a>
                </li>
            </ul>
        </div>
        <div class="pull-right" id="user_nav">
            <a id="user" href="{{ url('#') }}">Здравствуйте, {{ Auth::user()->name }}</a>
        </div>
    </div>

    <div class="container content_block">
        <div id="result"></div>
    </div>

    <div class="dropup">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Управление импортом
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2" id="importMenu">
            <li><a id="tp_creation" href="{{ url('#tp_creation') }}">Создание товарной партии</a></li>
            <li><a id="tp_edit" href="{{ url('#tp_edition') }}">Редактирование товарной партии</a></li>
            <li><a id="tp_deletion" href="{{ url('#tp_deletion') }}">Удаление товарной партии</a></li>
            <li><a id="uploading" href="{{ url('#uploading') }}">Загрузка списка</a></li>
            <li><a id="ta_creation" href="{{ url('#ta_creation') }}">Создание товарной акции</a></li>
            <li><a id="ta_edition" href="{{ url('#ta_edition') }}">Редактирование товарной акции</a></li>
            <li><a id="ta_deletion" href="{{ url('#ta_deletion') }}">Удаление товарной акции</a></li>
            <li><a id="linking" href="{{ url('#linking') }}">Привязка ТП к ТА</a></li>
            <li><a href="{{ url('#exporting') }}">Выгрузка файла в Excel</a></li>
            <li><a href="{{ url('#updating') }}">Обновление цен и остатков</a></li>
            <li class="none_found">
                <a class="none_found" href="#">Результатов не найдено</a>
            </li>
            <li role="separator" class="divider"></li>
            <li>
                <input type="text" placeholder="Поиск.." id="search" onkeyup="filterFunction()">
            </li>
        </ul>
    </div>

    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}" />
    <input type="hidden" id="current" name="current" value="self" />
    <input type="hidden" id="party_id" name="party_id" value="" />
    <input type="hidden" id="sale_id" name="sale_id" value="" />

@endsection