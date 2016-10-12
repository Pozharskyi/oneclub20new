@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.roles.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница добавления ролей</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/manage/roles/create') }}" method="post">

                    {{ csrf_field() }}

                    <label for="name">Имя роли</label>
                    <input type="text" class="form-control" name="name" id="name" />

                    <label for="description">Описание роли</label>
                    <input type="text" class="form-control" name="description" id="description" />

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Добавить роль</button>
                    </div>

                </form>

            </div>
            <div class="col-md-3"></div>

        </div>

    </div>

@endsection