@extends('layouts/adminPanel')

@section('title') Страница добавления товарных партий @stop

@section('content')

    @include('admin.import.sub-nav')
    @include('admin.import.update.nav.nav')

    <div class="container">

        <div class="text-center" style="margin: 25px 0 25px 0;">
            <h2>Просмотр обновления партий</h2>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#Id</th>
                <th>Название</th>
                <th>Рекомендованое время обновления</th>
                <th>Сделано</th>
                <th>Дата создания</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>

                @foreach( $data as $update )
                    <tr id="update_{{ $update->id }}">
                        <td>#{{ $update->id }}</td>
                        <td>{{ $update->update_name }}</td>
                        <td>{{ $update->recommended_start }}</td>
                        <td>{{ $update->user->name }}</td>
                        <td>{{ $update->created_at }}</td>
                        <td>
                            <a href="{{ url( '/admin/import/update/desc/' . $update->id ) }}">
                                <button class="btn btn-default">Просмотр</button>
                            </a>
                        </td>
                        <td>
                            <a href="javascript: void(0);" onclick="deleteUpdate({{ $update->id }});">X</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/import/update/main.js') }}"></script>

@endsection