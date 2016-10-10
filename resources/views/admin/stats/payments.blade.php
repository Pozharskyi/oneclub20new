@extends('layouts.adminPanel')

@section('title') Страница администирования Oneclub2.0 @stop

@section('content')

    @include('admin.stats.nav')

    <div class="container">
        <div class="text-center">
            <h2>Страница администрирования Oneclub2.0</h2>
            <h4>График использования типов оплат</h4>
        </div>

        <!-- HTML -->
        <div id="chartdiv" style="width: 100%; height: 500px;"></div>

        <div class="container">
            <div class="row">

                @foreach( $results as $category => $collection )
                    <h2>Статистика за: {{ $category }}</h2>

                    @if( count($collection ) == 0 )
                        <h3 style="color: rgb(240, 0, 140);">Данных не найдено.</h3>
                    @else
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Номер заказа</th>
                                <th>Имя клиента</th>
                                <th>Емейл клиента</th>
                                <th>Тип оплаты</th>
                                <th>Дата создания</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach( $collection as $info )
                                <tr>
                                    <td>{{ $info->public_order_id }}</td>
                                    <td>{{ $info->user->name }}</td>
                                    <td>{{ $info->user->email }}</td>
                                    <td>{{ $info->orderPaymentType->payment_type }}</td>
                                    <td>{{ $info->created_at }}</td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    @endif

                    <div style="width: 50%; margin: 25px auto 25px auto; height: 1px; background-color: chocolate"></div>

                @endforeach

            </div>
        </div>
    </div>

    <!-- Resources -->
    <script src="{{ url('https://www.amcharts.com/lib/3/amcharts.js') }}"></script>
    <script src="{{ url('https://www.amcharts.com/lib/3/serial.js') }}"></script>
    <script src="{{ url('https://www.amcharts.com/lib/3/plugins/export/export.min.js') }}"></script>
    <link rel="stylesheet" href="{{ url('https://www.amcharts.com/lib/3/plugins/export/export.css') }}" type="text/css" media="all" />
    <script src="{{ url('https://www.amcharts.com/lib/3/themes/light.js') }}"></script>

    <!-- Chart code -->
    <script src="{{ url('/js/admin/stats/payments.js') }}"></script>

@endsection