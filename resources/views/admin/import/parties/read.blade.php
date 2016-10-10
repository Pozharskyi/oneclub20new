@extends('layouts/adminPanel')

@section('title') Страница просмотра товарных партий @stop

@section('content')

    <div id="result_row"></div>

    @include('admin.import.sub-nav')
    @include('admin.import.parties.nav.nav')

    <div class="container">
        <div class="row">
            <div class="text-center" style="margin: 25px 0 25px 0;">
                <h2>Товарные партии категории "Каталог"</h2>
            </div>

            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id партии</th>
                            <th>Название</th>
                            <th>Поставщик</th>
                            <th>Рекомендованая дата старта</th>
                            <th>Рекомендованая дата конца</th>
                            <th>Сделано</th>
                            <th>Подтверждение</th>
                            <th>Дата создания</th>
                            <th>Просмотр</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach( $catalog as $item )
                            <tr id="party_{{ $item->id }}">
                                <td>#{{ $item->id }}</td>
                                <td>{{ $item->party_name }}</td>
                                <td>{{ $item->supplier->name }}</td>
                                <td>{{ $item->recommended_start }}</td>
                                <td>{{ $item->recommended_end }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>
                                    @if( $item->partiesProcess->is_processed == 0 )
                                        Не подтвержден
                                    @else
                                        Подтверджен
                                    @endif
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{ url( '/admin/import/parties/desc/' . $item->id ) }}">
                                        <button class="btn btn-default">Просмотр</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript: void(0);" onclick="deleteParty({{ $item->id }});">X</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="text-center" style="margin: 25px 0 25px 0;">
                <h2>Товарные партии категории "Акции"</h2>
            </div>

            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Id партии</th>
                        <th>Название</th>
                        <th>Поставщик</th>
                        <th>Рекомендованая дата старта</th>
                        <th>Рекомендованая дата конца</th>
                        <th>Сделано</th>
                        <th>Подтверждение</th>
                        <th>Дата создания</th>
                        <th>Просмотр</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach( $sale as $item )
                        <tr id="party_{{ $item->id }}">
                            <td>#{{ $item->id }}</td>
                            <td>{{ $item->party_name }}</td>
                            <td>{{ $item->supplier->name }}</td>
                            <td>{{ $item->recommended_start }}</td>
                            <td>{{ $item->recommended_end }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>
                                @if( $item->partiesProcess->is_processed == 0 )
                                    Не подтвержден
                                @else
                                    Подтверджен
                                @endif
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <a href="{{ url( '/admin/import/parties/desc/' . $item->id ) }}">
                                    <button class="btn btn-default">Просмотр</button>
                                </a>
                            </td>
                            <td>
                                <a href="javascript: void(0);" onclick="deleteParty({{ $item->id }});">X</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/import/parties/main.js') }}"></script>

@endsection