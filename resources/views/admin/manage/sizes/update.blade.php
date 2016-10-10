@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.sizes.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница изменения размера <br /> "{{ $size->name }}"</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/manage/sizes/update') }}" method="post">

                    {{ csrf_field() }}

                    <label for="size_name">Имя размера</label>
                    <input type="text" class="form-control" name="size_name" id="size_name" value="{{ $size->name }}" />

                    <label for="size_owner" style="margin-top: 25px;">Создатель размера</label>
                    <input type="text" class="form-control" name="size_owner" id="size_owner" value="{{ $size->user->name }}" disabled />

                    <input type="hidden" name="size_id" value="{{ $size->id }}" />

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Обновить размер</button>
                    </div>

                </form>

            </div>
            <div class="col-md-3"></div>

        </div>
    </div>

@endsection