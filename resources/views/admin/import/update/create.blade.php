@extends('layouts/adminPanel')

@section('title') Страница добавления обновления партий @stop

@section('content')

    @if( !is_null( $alert ) )

        @if( $alert == 'success' )
            <div class="alert alert-success" style="margin-top: -22px;">
                <strong>Успех!</strong> Обновление товаров было добавлено.
            </div>
        @elseif( $alert == 'failed' )
            <div class="alert alert-danger" style="margin-top: -22px;">
                <strong>Ошибка!</strong> Обновление товаров не было добавлено.
            </div>
        @endif

    @endif

    <div style="margin-top: 22px;"></div>

    @include('admin.import.sub-nav')
    @include('admin.import.update.nav.nav')

    <form action="{{ url('/admin/import/update/create') }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <label for="party_name" style="margin-top: 25px;">Название обновления товаров</label>
                    <input type="text" class="form-control" name="party_name" id="party_name" required />

                    <label for="recommended_start" style="margin-top: 25px;">Выберите рекомендованую дату начала</label>
                    <input type="text" class="form-control" placeholder="2016-09-10 10:10:10" name="recommended_start" id="recommended_start" required />

                    <br />

                    <label for="import" style="margin-top: 25px;">Выберите файл загрузки</label>
                    <input type="file" name="import" id="import" required />

                </div>
                <div class="col-md-4"></div>
            </div>

            <div class="text-center" style="margin-top: 30px; margin-bottom: 30px;">
                <button class="btn btn-warning">Создать обновление товаров</button>
            </div>

        </div>
    </form>

@endsection