@extends('layouts.app')

@section('content')

    <link rel="stylesheet" type="text/css" href="{{ url('/css/shop/checkout/checkout_conflict.css') }}" />

    <div id="modal_form"><!-- Popup window -->
        <span id="modal_close" onclick="closePopup();">X</span> <!-- Close button -->
        <div id="popup_content"></div>
    </div>
    <div id="overlay"></div><!-- Overlay -->

    <div id="validation" style="margin-top: -22px;">

        @if( $validation !== null )

            @if( $validation->error == 'product_reserved' )

                <div class="alert alert-danger">
                    <strong>Продукт был зарезервирован!</strong>
                    Доступное количество: {{ $validation->available }}, зарезервировано: {{ $validation->reserved }}
                </div>

            @elseif( $validation->error = 'product_adding' )

                <div class="alert alert-danger">
                    <strong>Данное количество продуктов не доступно!</strong>
                    Доступное количество: {{ $validation->available }}
                </div>

            @elseif( $validation->error = 'product_bought' )

                <div class="alert alert-danger">
                    <strong>Данный предмет уже был куплен!</strong>
                    Доступное количество: {{ $validation->available }}
                </div>

            @endif

        @endif

    </div>

    <div class="container" style="margin-top: 40px;">
        <h2>Ваша корзина</h2>
    </div>

    <div class="container-fluid" style="margin-bottom: 40px;">

        {{ csrf_field() }}

        @foreach( $collection as $item )

            <div class="container" id="item_{{ $item->id }}">

                <div style="width: 100%; height: 1px; background-color: rgb(240, 0, 140); margin: 20px 0 20px 0;"></div>

                <div class="row">
                    <div class="col-md-2">
                        <img src="{{ $item->subProduct->photos[0]->photo }}" style="width: 100%;" />
                    </div>
                    <div class="col-md-4">
                        <h4><b>{{ $item->subProduct->product->description->product_name }}</b></h4>
                        <h4>{{ $item->subProduct->product->brand->brand_name }}</h4>

                        <h4 style="margin-top: 70px;">Цвет: {{ $item->subProduct->color->name }}</h4>
                        <h4>Размер: {{ $item->subProduct->size->name }}</h4>
                    </div>
                    <div class="col-md-2">
                        <h4><b>Количество:</b></h4>

                        <a onclick="decreaseItem( {{ $item->id }} );" href="javascript: void(0);" style="float: left; font-size: 20px; margin-right: 5px;">
                            -
                        </a>

                        <input id="quantity_{{ $item->id }}" type="number" style="text-align: center; width: 70%; float: left;" class="form-control" min="1" max="{{ $item->quantity }}" value="{{ $item->sub_product_quantity }}" />

                        <a onclick="increaseItem( {{ $item->id }} );" href="javascript: void(0);" style="float: left; font-size: 20px; margin-left: 5px;">
                            +
                        </a>

                        <div style="margin-top: 40px;" id="cc_{{ $item->id }}">
                            <br />
                            <div id="counter_{{ $item->id }}"></div>
                        </div>

                    </div>

                    <input type="hidden" id="special_price_{{ $item->id }}" value="{{ $item->subProduct->price->final_price }}" />
                    <input type="hidden" id="final_price_{{ $item->id }}" value="{{ $item->subProduct->price->special_price }}" />

                    <div class="col-md-4">
                        <div class="pull-right">
                            <h4><b>Цена:</b></h4>
                            <h4><b><span id="product_price_{{ $item->id }}">{{ $item->subProduct->price->special_price * $item->sub_product_quantity }}</span></b> грн.</h4>
                            <h4>
                                <a onclick="deleteItem( {{ $item->id }} );" href="javascript: void(0);">
                                    Удалить
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <input type="hidden" id="xs-user-token" value="{{ $user_id }}" />

            <div class="container">

                @if( $count == 0 )

                    <h4 style="color: rgb(240, 0, 140);">Ваша корзина пуста</h4>

                @endif

                <div style="width: 100%; height: 1px; background-color: rgb(240, 0, 140); margin: 20px 0 20px 0;"></div>

                <div class="pull-left">

                    <a href="/list">
                        <button class="btn btn-default">Продолжить покупки</button>
                    </a>

                    @if( $count != 0 )

                        <a href="javascript: void(0);" onclick="validateProducts( {{ $user_id }});">
                            <button class="btn btn-primary">Оформить заказ</button>
                        </a>

                    @endif
                    
                </div>

                <div class="pull-right">
                    <h2>Сумма: <b><span id="total">{{ $total }}</span> грн.</b></h2>
                    <h3>Экономия: <span id="special">{{ $sale }}</span> грн.</h3>
                </div>

            </div>

    </div>

    @include('layouts.footer')

    <script src="{{ url('/js/shop/basket/basket.js') }}"></script>
    <script src="{{ url('/js/shop/basket/timers.js') }}"></script>
    <script src="{{ url('/js/shop/basket/edit.js') }}"></script>
    <script src="{{ url('/js/shop/checkout/reserve_conflict.js') }}"></script>

@endsection