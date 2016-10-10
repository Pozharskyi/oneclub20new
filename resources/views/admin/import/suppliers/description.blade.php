@extends('layouts/adminPanel')

@section('title') Страница просмотра поставщиков @stop

@section('content')

    @include('admin.import.sub-nav')
    @include('admin.import.suppliers.nav.nav')

    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">

                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Описание</th>
                        <th>Информация</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach( $results as $category => $tag )
                        <tr>
                            <td>{{ $category }}</td>
                            <td>{{ $tag }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>
            <div class="col-md-1"></div>
        </div>
    </div>

@endsection