@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.sizes.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница добавления размеров</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/manage/sizes/create') }}" method="post">

                    {{ csrf_field() }}

                    <label for="size_name">Имя размера</label>
                    <input type="text" class="form-control" name="size_name" id="size_name" />

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Добавить размер</button>
                    </div>

                </form>

            </div>
            <div class="col-md-3"></div>

        </div>

    </div>

@endsection