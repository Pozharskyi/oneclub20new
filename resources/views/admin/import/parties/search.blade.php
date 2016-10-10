@extends('layouts/adminPanel')

@section('title') Страница просмотра товарных партий @stop

@section('content')

    <div id="result_row"></div>

    @include('admin.import.sub-nav')
    @include('admin.import.parties.nav.nav')

    <div class="container">

        <div class="text-center" style="margin: 25px 0 25px 0;">
            <h2>Поиск по товарным партиям</h2>

            <p style="color: rgb(240, 0, 140);">Если поля не заполнены, по ним поиск не проходит</p>

        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-6">
                        <label for="id">Поиск по #Id партии</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="id" name="id" />
                    </div>
                </div>

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-6">
                        <label for="party_name">Поиск по названию партии</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="party_name" name="party_name" />
                    </div>
                </div>

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-6">
                        <label for="supplier_id">Поиск по Поставщику</label>
                    </div>
                    <div class="col-md-6">

                        <select id="supplier_id" name="supplier_id" class="form-control">

                            <option value=""></option>

                            @foreach( $suppliers as $item )
                                <option value="{{ $item->supplier->id }}">{{ $item->supplier->name }}</option>
                            @endforeach

                        </select>

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

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-6">
                        <label for="recommended_end">Поиск по рекомендованой дате конца</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="recommended_end" name="recommended_end" placeholder="2016-10-01 01:01:01" />
                    </div>
                </div>

                <div class="text-center" style="margin: 25px 0 25px 0;">
                    <button type="button" onclick="search();" class="btn btn-primary">Найти товарные партии</button>
                </div>

            </div>
            <div class="col-md-3"></div>
        </div>

        <div id="search_result" style="margin: 25px 0 25px 0;"></div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/import/parties/search.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/admin/import/parties/main.js') }}"></script>

@endsection