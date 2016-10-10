@extends('layouts/adminPanel')

@section('title') Страница просмотра товарных партий @stop

@section('content')

    <div id="result_row"></div>

    @include('admin.import.sub-nav')
    @include('admin.import.update.nav.nav')

    <div class="container">

        <div class="text-center" style="margin: 25px 0 25px 0;">
            <h2>Поиск по импорту обновлений</h2>

            <p style="color: rgb(240, 0, 140);">Если поля не заполнены, по ним поиск не проходит</p>

        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-6">
                        <label for="id">Поиск по #Id обновления</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="id" name="id" />
                    </div>
                </div>

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-6">
                        <label for="update_name">Поиск по названию обновления</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="update_name" name="update_name" />
                    </div>
                </div>

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-6">
                        <label for="made_by">Поиск по Создателям</label>
                    </div>
                    <div class="col-md-6">

                        <select id="made_by" name="made_by" class="form-control">

                            <option value=""></option>

                            @foreach( $users as $item )
                                <option value="{{ $item->user->id }}">{{ $item->user->name }}</option>
                            @endforeach

                        </select>

                    </div>
                </div>

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-6">
                        <label for="recommended_start">Поиск по рекомендованой дате старта</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="recommended_start" name="recommended_start" placeholder="2016-09-01 01:01:01" />
                    </div>
                </div>

                <div class="text-center" style="margin: 25px 0 25px 0;">
                    <button type="button" onclick="search();" class="btn btn-primary">Найти обновления</button>
                </div>

            </div>
            <div class="col-md-3"></div>
        </div>

        <div id="search_result" style="margin: 25px 0 25px 0;"></div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/import/update/search.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/admin/import/update/main.js') }}"></script>

@endsection