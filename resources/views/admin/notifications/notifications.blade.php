@extends('layouts.adminPanel')

@section('content')

    <link rel="stylesheet" type="text/css" href="{{ url('/css/admin/notifications/index.css') }}" />
    <script type="text/javascript" src="{{ url('/js/admin/notifications/index.js') }}"></script>

    @if( $success == 'true' )

        <div class="alert alert-success" style="margin-top: -20px;">
            <strong>Успех!</strong> Вы успешно добавили или изменили событие
        </div>

    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>

            <div class="col-md-4">
                <div class="content">
                    <label for="list">Выберите событие</label>

                    <form action="#" method="post">
                        <select onchange="getOptions( this.value );" class="form-control" id="list" name="list">
                            <option>Выбрать...</option>

                            @foreach( $list as $data )
                                <option value="{{ $data->id }}">{{ $data->notification }}</option>
                            @endforeach

                        </select>
                    </form>
                </div>
            </div>

            <div class="col-md-4"></div>
        </div>

        <div class="row">
            <div class="col-md-2"></div>

            <div class="col-md-8">
                <div id="options_result"></div>
            </div>

            <div class="col-md-2"></div>
        </div>

        <div class="row" style="margin-top: 25px;">
            <div class="col-md-2"></div>

            <div class="col-md-8">
                <div id="sequence_result"></div>
            </div>

            <div class="col-md-2"></div>
        </div>
    </div>

@endsection