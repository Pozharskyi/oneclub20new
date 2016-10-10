@extends('layouts/adminPanel')

@section('title') Страница просмотра загрузки товарной партии партий @stop

@section('content')

    <link rel="stylesheet" type="text/css" href="{{ url('/css/shop/checkout/checkout_conflict.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/admin/import/parties/main.css') }}" />

    <div id="modal_form" style="overflow-y: auto;"><!-- Popup window -->
        <span id="modal_close" onclick="closePopup();">X</span> <!-- Close button -->
        <div id="popup_content"></div>
    </div>
    <div id="overlay"></div><!-- Overlay -->

    @include('admin.import.sub-nav')
    @include('admin.import.parties.nav.nav')

    <div class="container">
        <div class="text-center">

            <h2>
                Описание импорта товарной партии <br />
                "{{ $info->party_name }}"
            </h2>

            <ul id="nav">

                <li>
                    <a href="javascript: void(0);" onclick="changeFatStatus( {{ $info->id . ', 0' }} );">Все</a>
                </li>

                @foreach( $fat_statuses as $fat_status )
                    <li>
                        <a href="javascript: void(0);" onclick="changeFatStatus( {{ $info->id . ',' . $fat_status->id }});">{{ $fat_status->fat_status }}</a>
                    </li>
                @endforeach

            </ul>
        </div>

        <div id="result">

            @include('admin.import.parties.fat_resolve')

        </div>
    </div>

    <form action="{{ url('/admin/import/parties/confirm/party') }}" method="post">
        <div class="text-center" style="margin: 25px 0 25px 0;">

            {{ csrf_field() }}

            <input type="hidden" name="party_id" id="party_id" value="{{ $info->id }}" />
            <button class="btn btn-default">Подтвердить товарную партию</button>
        </div>
    </form>

    <script type="text/javascript" src="{{ url('/js/admin/import/parties/fat.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/admin/import/parties/handler.js') }}"></script>

@endsection