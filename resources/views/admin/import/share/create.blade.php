@extends('layouts/adminPanel')

@section('title') Страница просмотра товарных акций @stop

@section('content')

    @if( !is_null( $message ) )
        @if( $message == 'false' )

            <div class="alert alert-danger" style="margin-top: -22px;">
                <strong>Ошибка!</strong> Что-то пошло не так. Данное название уже существует или попробуйте чуть позже.
            </div>

        @endif
    @endif

    @include('admin.import.sub-nav')
    @include('admin.import.share.nav.sub-nav')

    <form action="{{ url('/admin/import/share/create') }}" method="post">

        {{ csrf_field() }}

        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <label for="share_name" style="margin-top: 25px;">Название товарной акции</label>
                    <input type="text" class="form-control" name="share_name" id="share_name" required />

                    <label for="recommended_start" style="margin-top: 25px;">Выберите дату начала</label>
                    <input type="text" class="form-control" placeholder="2016-09-10 10:10:10" name="recommended_start" id="recommended_start" required />

                    <label for="recommended_end" style="margin-top: 25px;">Выберите дату конца</label>
                    <input type="text" class="form-control" placeholder="2016-09-20 10:10:10" name="recommended_end" id="recommended_end" required />

                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <label for="first_header" style="margin-top: 25px;">Хеадер h1</label>
                    <textarea name="first_header" id="first_header" class="form-control" rows="4" minlength="10"></textarea>

                    <label for="second_header" style="margin-top: 25px;">Хеадер h2</label>
                    <textarea name="second_header" id="second_header" class="form-control" rows="4" minlength="10"></textarea>
                </div>
            </div>

            <div class="text-center" style="margin-top: 30px; margin-bottom: 30px;">
                <button class="btn btn-warning">Создать товарную акцию</button>
            </div>

        </div>
    </form>

@endsection