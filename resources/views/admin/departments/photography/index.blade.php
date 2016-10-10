@extends('layouts/adminPanel')

@section('title') Страница добавления товарных партий @stop

@section('content')

    <link rel="stylesheet" type="text/css" href="{{ url('/css/shop/checkout/checkout_conflict.css') }}" />

    <div id="modal_form" style="overflow-y: auto;"><!-- Popup window -->
        <span id="modal_close" onclick="closePopup();">X</span> <!-- Close button -->
        <div id="popup_content"></div>
    </div>
    <div id="overlay"></div><!-- Overlay -->

    @include('admin.departments.alerts');

    <div class="container">
        <div class="text-center" style="margin-bottom: 40px;">
            <h2>Страница управления фотосьемкой для товаров</h2>
        </div>

        <div class="row" style="margin-top: 15px;">

            @if($count == 0)

                <h3 style="color: rgb(240, 0, 140);">Продуктов не найдено.</h3>

            @else

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Sku</th>
                        <th>Barcode</th>
                        <th>Цвет</th>
                        <th>Размер</th>
                        <th>Сообщение</th>
                        <th>Фото</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($products as $product)
                        <tr id="product_{{ $product->sub_product_id }}" style="cursor: pointer;" onclick="editProduct({{ $product->sub_product_id }});">
                            <td>{{ $product->subProduct->product->sku }}</td>
                            <td>{{ $product->subProduct->barcode }}</td>
                            <th>{{ $product->subProduct->color->name }}</th>
                            <th>{{ $product->subProduct->size->name }}</th>
                            <th>
                                <span style="color: rgb(240, 0, 140);">
                                    {{ $product->message }}
                                </span>
                            </th>
                            <th>
                                <img src="{{ $product->subProduct->photos[0]->photo }}" style="width: 100px;" />
                            </th>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            @endif

        </div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/import/parties/fat.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/admin/departments/photography/main.js') }}"></script>

@endsection