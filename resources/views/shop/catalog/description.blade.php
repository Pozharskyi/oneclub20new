@extends('layouts.app')

@section('content')

    <div class="container" id="content_row" style="margin: 45px auto 45px auto;">
        <div class="row">
            <div class="col-md-2">

                @foreach( $collection->subProducts as $item )

                    <img src="{{ $item->photos[0]->photo }}" style="width: 100%; margin-bottom: 15px;" />

                @endforeach

            </div>

            <div class="col-md-5">

                <img src="{{ $product_photo }}" style="width: 100%;" />

            </div>

            <div class="col-md-5">

                <h3>{{ $collection->description->product_name }}</h3>
                <h4>{{ $collection->brand->brand_name }}</h4>

                <h5>Код товара: {{ $collection->product_store_id }}</h5>

                @if(!empty($sizeCharts))
                    @include('shop.catalog.size_chart')
                @endif

                <div style="width: 100%; height: 60px;">
                    <div class="pull-left" style="margin-right: 25px;">
                        <h3 style="color: #555;">
                            <strike>{{ $collection->subProducts[0]->price->final_price }} грн.</strike>
                        </h3>
                    </div>

                    <div class="pull-left">
                        <h3 style="color: rgb(240, 0, 140);">
                            {{ $collection->subProducts[0]->price->special_price }} грн.
                        </h3>
                    </div>
                </div>

                <div style="width: 100%; height: 1px; background-color: rgb(240, 0, 140); margin: 20px 0 20px 0;"></div>

                <form action="/list/save/{{ $product_id }}" method="post">

                    {{ csrf_field() }}

                    <h4>Цвет:</h4>

                    @foreach( $collection->subProducts as $product )

                        <input type="radio" onclick="getProductSizes( {{ $product->color->id }} );" name="color" id="color" value="{{ $product->color->id }}" required

                            @if( $product->color->id == $color_id )

                                checked

                            @endif

                        /> {{ $product->color->name }}

                    @endforeach

                    <div style="width: 100%; height: 1px; background-color: rgb(240, 0, 140); margin: 20px 0 20px 0;"></div>

                    <h4>Размер:</h4>

                    <div id="sizes_box">
                        @foreach( $sizes as $data )

                            <input type="radio" onclick="getProductQuantity( {{ $data->size->id }} )" name="size" id="size" value="{{ $data->size->id }}" required /> {{ $data->size->name }}

                        @endforeach
                    </div>

                    <div style="width: 100%; height: 1px; background-color: rgb(240, 0, 140); margin: 20px 0 20px 0;"></div>

                    <h4>Количество:</h4>

                    <select id="quantity" name="quantity" required>

                        <option value="0">0</option>

                    </select>

                    <div class="pull-right" style="margin-top: -15px;">
                        <button class="btn btn-primary">Добавить в корзину</button>
                    </div>
                </form>

                <div style="width: 100%; height: 1px; background-color: rgb(240, 0, 140); margin: 20px 0 20px 0;"></div>

                <h5>
                    <b>Состав:</b> {{ $collection->description->product_composition }}
                </h5>

                <h5>
                    <b>Описание:</b> {{ $collection->description->product_description }}
                </h5>

                <h5>
                    <b>Ожидаемая дата доставки:</b> {{ $estimated_delivery_date }}
                </h5>

            </div>
        </div>
    </div>

    <input type="hidden" name="pr_oc" id="pr_oc" value="{{ $product_id }}" />

    @include('layouts.footer')

    <script type="text/javascript" src="{{ url('/js/shop/catalog/description.js') }}"></script>

@endsection