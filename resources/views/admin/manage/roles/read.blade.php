@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.alert')

    @include('admin.manage.sub-nav')
    @include('admin.manage.roles.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница просмотра ролей</h2>
        </div>

        <div class="row">

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Дата создания</th>
                    <th>Дата обновления</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach( $roles as $role )

                    <tr id="role_{{ $role->id }}">
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                        <td>{{ $role->created_at }}</td>
                        <td>{{ $role->updated_at }}</td>
                        <td>
                            <a href="{{ url( '/admin/manage/roles/update/' . $role->id ) }}">Редактировать</a>
                        </td>
                        <td>
                            <a onclick="deleteColor({{ $role->id }});" href="javascript: void(0);">X</a>
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>

        </div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/manage/roles/main.js') }}"></script>

@endsection