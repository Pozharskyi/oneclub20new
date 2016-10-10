@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.brands.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница изменения бренда <br /> "{{ $brand->brand_name }}"</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/manage/brands/update') }}" method="post">

                    {{ csrf_field() }}

                    <label for="brand_name">Имя бренда</label>
                    <input type="text" class="form-control" name="brand_name" id="brand_name" value="{{ $brand->brand_name }}" />

                    <label for="brand_owner" style="margin-top: 25px;">Создатель бренда</label>
                    <input type="text" class="form-control" name="brand_owner" id="brand_owner" value="{{ $brand->user->name }}" disabled />

                    <input type="hidden" name="brand_id" value="{{ $brand->id }}" />

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Обновить бренд</button>
                    </div>

                </form>

            </div>
            <div class="col-md-3"></div>

        </div>
    </div>

@endsection