@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.alert')

    @include('admin.manage.sub-nav')
    @include('admin.manage.brands.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница просмотра брендов</h2>
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

                    @foreach( $brands as $brand )

                        <tr id="brand_{{ $brand->id }}">
                            <td>{{ $brand->brand_name }}</td>
                            <td>{{ $brand->user->name }}</td>
                            <td>{{ $brand->created_at }}</td>
                            <td>{{ $brand->updated_at }}</td>
                            <td>
                                <a href="{{ url( '/admin/manage/brands/update/' . $brand->id ) }}">Редактировать</a>
                            </td>
                            <td>
                                <a onclick="deleteBrand({{ $brand->id }});" href="javascript: void(0);">X</a>
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/manage/brands/main.js') }}"></script>

@endsection