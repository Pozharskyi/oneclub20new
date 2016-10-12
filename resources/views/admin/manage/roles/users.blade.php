@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.roles.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница просмотра пользователей для роли {{$role->name}}</h2>
        </div>

        <div class="row">

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach( $users as $user )

                    <tr id="user_{{ $user->id }}">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ url( '/admin/users/'.$user->id.'/manage_role') }}">Редактировать роли</a>
                        </td>

                    </tr>

                @endforeach

                </tbody>
            </table>

        </div>
    </div>

@endsection