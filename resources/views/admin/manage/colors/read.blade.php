@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.alert')

    @include('admin.manage.sub-nav')
    @include('admin.manage.colors.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница просмотра цветов</h2>
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

                    @foreach( $colors as $color )

                        <tr id="color_{{ $color->id }}">
                            <td>{{ $color->name }}</td>
                            <td>{{ $color->user->name }}</td>
                            <td>{{ $color->created_at }}</td>
                            <td>{{ $color->updated_at }}</td>
                            <td>
                                <a href="{{ url( '/admin/manage/colors/update/' . $color->id ) }}">Редактировать</a>
                            </td>
                            <td>
                                <a onclick="deleteColor({{ $color->id }});" href="javascript: void(0);">X</a>
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/manage/colors/main.js') }}"></script>

@endsection