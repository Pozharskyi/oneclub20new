@extends('layouts.adminPanel')

@section('title') Users @stop

@section('breadcrumb')
    <li><a href={{route('adminTable.users.searchUser')}}>Выбор пользователя</a> <span class="divider"></span></li>
    <li class="active">Выбор роли</li>
@endsection

@section('content')
    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница добавления ролей</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/users/'. $user->id .'/manage_role') }}" method="post">

                    {{ csrf_field() }}

                    <label>Выберите роль пользователю {{$user->name}}</label>
                    @foreach($roles as $role)
                        <div class="checkbox">
                            <label><input {{in_array($role->id, $user->roles->lists('id')->toArray()) ? 'checked' : ''}}
                                          type="checkbox" name="roleIds[]"
                                          value="{{$role->id}}"
                                >{{$role->name}}</label>
                        </div>

                    @endforeach

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Добавить роли</button>
                    </div>
                </form>

            </div>
            <div class="col-md-3"></div>

        </div>

    </div>

@stop
