@extends('layouts.adminPanel')

@section('title') Страница управления размерными сетками @stop

@section('content')

    @include('admin.manage.alert')

    @include('admin.manage.sub-nav')
    @include('admin.manage.size_chart.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница просмотра расзмерных сеток</h2>
        </div>

        <div class="row">

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Бренд</th>
                    <th>Категория</th>
                    <th>Международный размер</th>
                    <th>Размер производителя</th>
                    @foreach($measurementNames as $measurementName)
                        <th>{{$measurementName->name}}</th>
                    @endforeach
                    <th>Дата создания</th>
                    <th>Дата обновления</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach( $sizeCharts as $sizeChart )
                    <tr id="sizeChart_{{ $sizeChart->id }}">
                        <td>{{ $sizeChart->brand->brand_name }}</td>
                        <td>{{ $sizeChart->category->category_name }}</td>
                        <td>{{ $sizeChart->size->name }}</td>
                        <td>{{ $sizeChart->brand_size }}</td>
                        {{--fill $sizeChart->measurement->value if it exists else fill "-"--}}
                        @for($i=0; $i < $measurementNames->count(); $i++)
                            @php
                            $isInSizeChartNameIds = false
                            @endphp
                            @foreach($sizeChart->measurements as $measurement)
                                @if($measurement->name->id === $measurementNames[$i]->id)
                                    @php
                                    $isInSizeChartNameIds = true;
                                    $measurementValue = $measurement->value;
                                    @endphp
                                @endif
                            @endforeach
                            @if($isInSizeChartNameIds)
                                <th>{{$measurementValue}}</th>
                            @else
                                <th>-</th>
                            @endif
                        @endfor
                        <td>{{ $sizeChart->created_at }}</td>
                        <td>{{ $sizeChart->updated_at }}</td>
                        <td>
                            <a href="{{ url( '/admin/manage/size_chart/update/' . $sizeChart->id ) }}">Редактировать</a>
                        </td>
                        <td>
                            <a onclick="deleteSizeChart({{ $sizeChart->id }});"
                               href="javascript: void(0);">X</a>
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>

        </div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/manage/size_chart/main.js') }}"></script>

@endsection