@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.brands.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница добавления брендов</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/manage/brands/create') }}" method="post">

                    {{ csrf_field() }}

                    <label for="brand_name">Имя бренда</label>
                    <input type="text" class="form-control" name="brand_name" id="brand_name" />

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Добавить бренд</button>
                    </div>

                </form>

            </div>
            <div class="col-md-3"></div>

        </div>

    </div>

@endsection