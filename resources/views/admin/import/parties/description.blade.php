@extends('layouts/adminPanel')

@section('title') Страница добавления товарных партий @stop

@section('content')

    @include('admin.import.sub-nav')
    @include('admin.import.parties.nav.nav')

    <div class="container" style="margin-top: 10px; margin-bottom: 25px;">
        <div class="text-center">
            <h2>
                Подробная информация о товарной партии "{{ $info->party_name }}", <br />
                категория "{{ $info->partiesCategory->type }}"
            </h2>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h4>Название партии: <span style="color: rgb(240, 0, 140);">{{ $info->party_name }}</span></h4>
                <h4>Поставщик: <span style="color: rgb(240, 0, 140);">{{ $info->supplier->name }}</span></h4>
                <h4>Рекомендованный старт: <span style="color: rgb(240, 0, 140);">{{ $info->recommended_start }}</span></h4>
                <h4>Рекомендованный конец: <span style="color: rgb(240, 0, 140);">{{ $info->recommended_end }}</span></h4>
                <h4>Сделано: <span style="color: rgb(240, 0, 140);">{{ $info->user->name }}</span></h4>
                <h4>Категория: <span style="color: rgb(240, 0, 140);">{{ $info->partiesCategory->type }}</span></h4>

                <div class="pull-right">
                    <a href="{{ url( '/admin/import/parties/edit/' . $info->id ) }}">
                        <button class="btn btn-default">Редактировать</button>
                    </a>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="text-center">
            <div class="divider"></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h4>Статус: <span style="color: rgb(240, 0, 140);">{{ $info->partiesProcess->fat_status }}</span></h4>
                <h4>Загружено товаров: <span style="color: rgb(240, 0, 140);">{{ $info->partiesProcess->in_process_atm }}</span> ( {{ $succeed }}% )</h4>
                <h4>Всего товаров: <span style="color: rgb(240, 0, 140);">{{ $info->partiesProcess->in_process_total }}</span></h4>
                <h4>Файл импорта: <a href="/{{ $info->partiesProcess->file_base_path }}">получить {{ $info->party_name }}</a></h4>
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="text-center">
            <div class="divider"></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">

                <h3 style="color: rgb(240, 0, 140);">Успешность импорта:</h3>

                @foreach( $fat as $status )
                    <h4>{{ $status->fat->fat_status }}: {{ $status->total }}</h4>
                @endforeach

                    <a href="{{ url('/admin/import/parties/fat/' . $info->id ) }}">Посмотреть детальнее...</a>
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="text-center">
            <div class="divider"></div>
        </div>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-4">
                <label for="sku">Поиск по артикулу</label>
                <input type="text" id="sku" name="sku" class="form-control" />

                <button type="button" style="margin-top: 10px;" class="btn btn-primary" onclick="searchBySku();">Найти совпадения</button>
                <button type="button" style="margin-top: 10px;" class="btn btn-warning" onclick="clearSearch();">Отменить</button>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label for="barcode">Поиск по баркоду</label>
                <input type="text" id="barcode" name="barcode" class="form-control" />

                <button type="button" style="margin-top: 10px;" class="btn btn-primary" onclick="searchByBarcode();">Найти совпадения</button>
                <button type="button" style="margin-top: 10px;" class="btn btn-warning" onclick="clearSearch();">Отменить</button>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div id="result">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Sku</th>
                    <th>Barcode</th>
                    <th>Цена</th>
                    <th>Цена продажи</th>
                    <th>Цвет</th>
                    <th>Размер</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach( $products as $product )
                    <tr id="product_{{ $product->id }}">
                        <td>{{ $product->product->sku }}</td>
                        <td>{{ $product->barcode }}</td>
                        <td>{{ $product->price->final_price }} грн.</td>
                        <td>{{ $product->price->special_price }} грн.</td>
                        <td>{{ $product->color->name }}</td>
                        <td>{{ $product->size->name }}</td>
                        <td>
                            <a href="javascript: void(0);" onclick="deleteSubProduct({{ $product->id }});">X</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <script type="text/javascript" src="{{ url('/js/admin/import/parties/descriptionSearch.js') }}"></script>

@endsection