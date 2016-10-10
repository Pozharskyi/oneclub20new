@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-sm-2 col-md-2">
        @include('user.cabinet.cabinet_menu')
    </div>
    <div class="col-xs-12 col-sm-10 col-md-10">
        <h2>Заказ {{ $data->public_order_id }}</h2>
        @if(count($data->subProducts) != 0)
            <div class="col-xs-12 col-sm-12 col-md-12 well panel-heading">
                <div class="col-xs-3 col-sm-3 col-md-3">Фото</div>
                <div class="col-xs-3 col-sm-3 col-md-3">Товар</div>
                <div class="col-xs-2 col-sm-2 col-md-2">Количество</div>
                <div class="col-xs-2 col-sm-2 col-md-2">Цена за ед.</div>
                <div class="col-xs-2 col-sm-2 col-md-2">Статус</div>
            </div>

            @foreach($data->subProducts as $product)
                <div class="col-xs-12 col-sm-12 col-md-12 well">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <img src="{{ $product->photos[0]['photo'] }}" style="max-width:120px; max-height: 120px;">
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <a href="/list/{{ $product->product->product_store_id }}/{{ $product->color->id }}">Код товара: {{ $product->barcode }}<br>
                        Размер: {{ $product->size->name }}<br>
                        Цвет: {{ $product->color->name }}</a>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        {{ $product->pivot->qty }}
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        {{ $product->price->special_price }}
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        {{ $order_status[$product->pivot->dev_order_status_list_id] }}
                        @if($product->pivot->dev_order_status_list_id < 10)
                            <a>Отменить</a>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="col-xs-12 col-sm-12 col-md-12 text-right">
            <h3>Итого: {{ $data->total_sum }}</h3>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 well">
                <h4>Адрес доставки:</h4>
                Адрес: {{ $data->orderDelivery['delivery_address'] }}<br>
                ФИО: {{ $data->orderDelivery['delivery_l_name'] }} {{ $data->orderDelivery['delivery_f_name'] }}<br>
                Телефон: {{ $data->orderDelivery['delivery_phone'] }}<br>
            </div>
        @else
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                Товары отсутствуют
            </div>
        @endif
    </div>
@endsection