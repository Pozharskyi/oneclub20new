@extends('layouts/adminPanel')

@section('title') Страница просмотра загрузки товарной партии партий @stop

@section('content')

    <link rel="stylesheet" type="text/css" href="{{ url('/css/shop/checkout/checkout_conflict.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/admin/import/parties/main.css') }}" />

    <div id="modal_form"><!-- Popup window -->
        <span id="modal_close" onclick="closePopup();">X</span> <!-- Close button -->
        <div id="popup_content"></div>
    </div>
    <div id="overlay"></div><!-- Overlay -->

    @include('admin.import.sub-nav')
    @include('admin.import.update.nav.nav')

    <div class="container">
        <div class="text-center">

            <h2>
                Описание обновления товарной партии <br />
                "{{ $info->update_name }}"
            </h2>

            <ul id="nav">

                <li>
                    <a href="javascript: void(0);" onclick="changeFatStatus( {{ $info->id . ', 0' }} );">Все</a>
                </li>

                @foreach( $fat_statuses as $fat_status )
                    <li>
                        <a href="javascript: void(0);" onclick="changeFatStatus( {{ $info->id . ',' . $fat_status->fatStatus->id }});">{{ $fat_status->fatStatus->fat_status }}</a>
                    </li>
                @endforeach

            </ul>
        </div>

        <div id="result">

            @include('admin.import.update.fat_resolve')

        </div>
    </div>

    <input type="hidden" name="update_id" id="update_id" value="{{ $info->id }}" />

    <script type="text/javascript" src="{{ url('/js/admin/import/parties/fat.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/admin/import/update/fat.js') }}"></script>

@endsection