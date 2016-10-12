@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.roles.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница изменения роли <br /> "{{ $role->name }}"</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/manage/roles/update') }}" method="post">

                    {{ csrf_field() }}

                    <label for="role_name">Имя роли</label>
                    <input type="text" class="form-control" name="role_name" id="role_name" value="{{ $role->name }}" />

                    <label for="role_description">Описание роли</label>
                    <input type="text" class="form-control" name="role_description" id="role_description"  value="{{ $role->description }}"/>

                    <input type="hidden" name="role_id" value="{{ $role->id }}" />

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Обновить роль</button>
                    </div>

                </form>

            </div>
            <div class="col-md-3"></div>

        </div>
    </div>

@endsection