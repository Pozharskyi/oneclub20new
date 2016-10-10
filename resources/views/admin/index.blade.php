@extends('layouts.adminPanel')

@section('title') Страница администирования Oneclub2.0 @stop

@section('content')

    @include('admin.stats.nav')

    <div class="container">
        <div class="text-center">
            <h2>Страница администрирования Oneclub2.0</h2>
            <h4>График поступления заказов( соответсвие день - количество )</h4>
        </div>

        <div id="chartdiv" style="width: 100%; min-height: 500px;"></div>

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
                                <th>Статус</th>
                                <th>Количество предметов</th>
                                <th>Сумма заказа</th>
                                <th>Дата создания</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php $total_sum = 0 @endphp
                            @php $total_quantity = 0 @endphp
                            @php $i = 0 @endphp

                            @foreach( $collection as $info )
                                <tr>
                                    <td>{{ $info->public_order_id }}</td>
                                    <td>{{ $info->user->name }}</td>
                                    <td>{{ $info->user->email }}</td>
                                    <td>Оплачен/не доставлен</td>
                                    <td>{{ $info->total_quantity }} шт.</td>
                                    <td>{{ $info->total_sum }} UAH</td>
                                    <td>{{ $info->created_at }}</td>
                                </tr>

                                @php $total_sum += $info->total_sum @endphp
                                @php $total_quantity += $info->total_quantity @endphp
                                @php $i++ @endphp

                            @endforeach

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <span style="color: rgb(240, 0, 140);">
                                        Среднее:
                                    </span>
                                </td>
                                <td>{{ round($total_quantity / $i, 2) }} шт.</td>
                                <td>{{ round($total_sum / $i, 2) }} UAH</td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <span style="color: rgb(240, 0, 140);">
                                        Сумма:
                                    </span>
                                </td>
                                <td>{{ $total_quantity }} шт.</td>
                                <td>{{ $total_sum }} UAH</td>
                                <td></td>
                                <td></td>
                            </tr>

                            </tbody>
                        </table>
                    @endif

                    <div style="width: 50%; margin: 25px auto 25px auto; height: 1px; background-color: chocolate"></div>

                @endforeach

            </div>
        </div>
    </div>

    <script src="{{ url('https://www.amcharts.com/lib/3/amcharts.js') }}"></script>
    <script src="{{ url('https://www.amcharts.com/lib/3/serial.js') }}"></script>
    <script src="{{ url('https://www.amcharts.com/lib/3/themes/light.js') }}"></script>

    <script src="{{ url('https://www.amcharts.com/lib/3/plugins/export/export.min.js') }}"></script>
    <link rel="stylesheet" href="{{ url('https://www.amcharts.com/lib/3/plugins/export/export.css') }}" type="text/css" media="all" />

    <script src="{{ url('/js/token.js') }}"></script>
    <script src="{{ url('/js/admin/main.js') }}"></script>

@endsection