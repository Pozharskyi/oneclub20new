@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.alert')

    @include('admin.manage.sub-nav')
    @include('admin.manage.sizes.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница просмотра размеров</h2>
        </div>

        <div class="row">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Кем было сделано</th>
                        <th>Дата создания</th>
                        <th>Дата обновления</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach( $sizes as $size )

                        <tr id="size_{{ $size->id }}">
                            <td>{{ $size->name }}</td>
                            <td>{{ $size->user->name }}</td>
                            <td>{{ $size->created_at }}</td>
                            <td>{{ $size->updated_at }}</td>
                            <td>
                                <a href="{{ url( '/admin/manage/sizes/update/' . $size->id ) }}">Редактировать</a>
                            </td>
                            <td>
                                <a onclick="deleteSize({{ $size->id }});" href="javascript: void(0);">X</a>
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/manage/sizes/main.js') }}"></script>

@endsection