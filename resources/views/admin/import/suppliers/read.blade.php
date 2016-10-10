@extends('layouts/adminPanel')

@section('title') Страница просмотра поставщиков @stop

@section('content')

    @include('admin.import.sub-nav')
    @include('admin.import.suppliers.nav.nav')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <label for="supplier">Поиск по поставщику</label>
                <input type="text" id="supplier" class="form-control" placeholder="Поставщик..." />
            </div>
            <div class="col-md-2">
                <button type="button" onclick="findSupplier();" style="margin-top: 27px;" class="btn btn-primary">Найти...</button>
            </div>
            <div class="col-md-6">
                <div class="pull-right" id="cancel"></div>
            </div>
        </div>

        <table class="table table-striped" style="margin-top: 35px;">
            <thead>
            <tr>
                <th>Id поставщика</th>
                <th>Имя поставщика</th>
                <th>Контактное лицо</th>
                <th>Телефоны</th>
                <th>Коефициент наценки</th>
                <th>Ожидающая маржа</th>
                <th>Договор</th>
                <th>Ответственный</th>
                <th>Кем был создан</th>
                <th>Дата создания</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="lead_body">

                @foreach( $suppliers as $supplier )
                    <tr id="result_{{ $supplier->id }}">
                        <td>#{{ $supplier->id }}</td>
                        <td>{{ $supplier->name }}</td>
                        <th>{{ $supplier->contact_person }}</th>
                        <th>{{ $supplier->phones }}</th>
                        <th>{{ $supplier->coefficient }}</th>
                        <th>{{ $supplier->product_marga }}</th>
                        <th>{{ $supplier->agreement }}</th>
                        <th>{{ $supplier->buyer->name }}</th>
                        <td>{{ $supplier->user->name }}</td>
                        <td>{{ $supplier->created_at }}</td>
                        <td>
                            <a onclick="deleteSupplier({{ $supplier->id }});" href="javascript: void(0);">X</a>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="11">
                            <a href="{{ url('/admin/import/suppliers/desc/' . $supplier->id) }}">
                                <button class="btn btn-default">Посмотреть</button>
                            </a>
                            <a href="{{ url('admin/import/suppliers/update/' . $supplier->id) }}">
                                <button class="btn btn-primary">Изменить</button>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/import/supplier/supplier.js') }}"></script>

@endsection