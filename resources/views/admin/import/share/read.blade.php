@extends('layouts/adminPanel')

@section('title') Страница просмотра товарных акций @stop

@section('content')

    @if( !is_null( $message ) )
        @if( $message == 'true' )

            <div class="alert alert-success" style="margin-top: -22px;">
                <strong>Успех!</strong> Вы успешно добавили товарную акцию.
            </div>

        @elseif( $message == 'changed' )

                <div class="alert alert-success" style="margin-top: -22px;">
                    <strong>Успех!</strong> Вы успешно изменили товарную акцию.
                </div>

        @endif
    @endif

    @include('admin.import.sub-nav')
    @include('admin.import.share.nav.sub-nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 25px;">
            <h2>Просмотр всех распродаж</h2>
        </div>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-4">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search ..." />
            </div>
            <div class="col-md-2">
                <button type="button" onclick="search( 'find' );" class="btn btn-primary">Найти</button>
            </div>
            <div class="col-md-6">
                <div class="pull-right" id="clear"></div>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Имя распродажи</th>
                <th>Рекомендованая дата начала</th>
                <th>Рекомендованая дата конца</th>
                <th>Сделано</th>
                <th>Изменить</th>
                <th>Статистика</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="result_row">

            @foreach( $shares as $share )

                <tr id="share_{{ $share->id }}">
                    <td>#{{ $share->id }}</td>
                    <td>{{ $share->sales_share_name }}</td>
                    <td>{{ $share->sales_share_start }}</td>
                    <td>{{ $share->sales_share_end }}</td>
                    <td>{{ $share->user->name }}</td>
                    <td>
                        <a href="{{ url( '/admin/import/share/desc/' . $share->id ) }}">
                            <button class="btn btn-default">Изменить</button>
                        </a>
                    </td>
                    <td>
                        <a href="{{ url( '/admin/import/share/stats/' . $share->id ) }}">
                            <button class="btn btn-default">Посмотреть</button>
                        </a>
                    </td>
                    <td>
                        <a href="javascript: void(0);" onclick="deleteShare({{ $share->id }});">X</a>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/import/share/main.js') }}"></script>

@endsection