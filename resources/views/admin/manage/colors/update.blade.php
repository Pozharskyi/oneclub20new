@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.colors.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница изменения цвета <br /> "{{ $color->name }}"</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/manage/colors/update') }}" method="post">

                    {{ csrf_field() }}

                    <label for="color_name">Имя цвета</label>
                    <input type="text" class="form-control" name="color_name" id="color_name" value="{{ $color->name }}" />

                    <label for="color_owner" style="margin-top: 25px;">Создатель цвета</label>
                    <input type="text" class="form-control" name="color_owner" id="color_owner" value="{{ $color->user->name }}" disabled />

                    <input type="hidden" name="color_id" value="{{ $color->id }}" />

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Обновить цвет</button>
                    </div>

                </form>

            </div>
            <div class="col-md-3"></div>

        </div>
    </div>

@endsection