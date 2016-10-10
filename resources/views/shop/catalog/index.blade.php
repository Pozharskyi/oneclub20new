@extends('layouts.app')

@section('content')

    <div class="container" style="margin: 40px auto 40px auto;">
        <div class="row">

            <div class="col-md-3">

                <form id="f_sort" name="">

                    <h3 class="lead">Категории</h3>
                    <div class="divider"></div>

                    @foreach( $results[0] as $result )

                        <a onclick="changeCategory({{ $result['id'] }});" href="javascript: void(0);">{{ $result['category_name'] }}</a>

                        @php $in_array = array_key_exists( $result['id'], $results ) @endphp

                        @if( $in_array )

                            - <a onclick="getSub({{ $result['id'] }});" href="javascript: void(0);">Суб</a><br />

                            <div id="cat{{ $result['id'] }}" style="display: none; margin-left: 7px;">

                                @foreach( $results[$result['id']] as $res )

                                    <a style="color: red;" onclick="changeCategory({{ $result['id'] }});" href="javascript: void(0);">{{ $res['category_name'] }}</a>

                                    @php $in = array_key_exists( $result['id'], $results ) @endphp

                                    @if( $in )

                                        - <a onclick="getSub({{ $res['id'] }});" href="javascript: void(0);">Суб</a><br />

                                        <div id="cat{{ $res['id'] }}" style="display: none; margin-left: 15px;">

                                            @foreach( $results[$res['id']] as $r )

                                                <a onclick="changeCategory({{ $r['id'] }});" style="color: green;" href="javascript: void(0);">{{ $r['category_name'] }}</a><br />

                                            @endforeach

                                        </div>

                                    @else
                                        <br />
                                    @endif

                                @endforeach

                            </div>

                        @else
                            <br />
                        @endif

                    @endforeach

                    <h3 class="lead">Размер</h3>
                    <div class="divider"></div>

                    @foreach( $sizes as $size )
                        <input type="checkbox" name="sizes" class="sizes" value="{{ $size->id }}" />{{ $size->name }} <br />
                    @endforeach

                    <h3 class="lead">Цвет</h3>
                    <div class="divider"></div>

                    @foreach( $colors as $color )
                        <input type="checkbox" name="colors" class="colors" value="{{ $color->id }}" />{{ $color->name }} <br />
                    @endforeach

                    <h3 class="lead">Цена</h3>
                    <div class="divider"></div>

                    From <input type="number" class="form-control" id="from_price" name="from_price" />
                    To <input type="number" class="form-control" id="end_price" name="end_price" />

                </form>

                <div class="pull-left" style="margin-top: 15px;">
                    <button onclick="sortCatalog( 'reset', 'reset' );" class="btn btn-default">Сбросить</button>
                </div>

                <div class="pull-right" style="margin-top: 15px;">
                    <button onclick="sortCatalog( 'default', 'default' );" class="btn btn-primary">Применить</button>
                </div>

            </div>

            <div class="col-md-9">

                <div class="row">

                    <div class="row">
                        <div class="col-md-2">
                            <p>Сортировать по</p>
                        </div>
                        <div class="col-md-2">
                            <a class="lead-sort" onclick="sortCatalog('rating', 'asc');" href="javascript: void(0);">Популярности</a>
                        </div>
                        <div class="col-md-2">
                            <a class="lead-sort" onclick="sortCatalog('price', 'desc');" href="javascript: void(0);">Цене вверх</a>
                        </div>
                        <div class="col-md-2">
                            <a class="lead-sort" onclick="sortCatalog('price', 'asc');" href="javascript: void(0);">Цене вниз</a>
                        </div>
                        <div class="col-md-2">
                            <a class="lead-sort" onclick="sortCatalog('sale', 'desc');" href="javascript: void(0);">% скидки</a>
                        </div>
                        <div class="col-md-2">
                            <input type="checkbox" id="hidden" /> Скрыть проданные
                        </div>
                    </div>

                    <div id="catalog_items">

                        @if( $qty == 0 )

                            <h3 style="color: rgb(240, 0, 140);">Результатов не найдено</h3>

                        @else

                            @php $i = 0 @endphp

                            @foreach( $collection as $item )

                                @if( $i == 0 || $i % 3 == 0 )
                                    <div class="row">
                                @endif

                                    <div class="col-md-4">

                                        <a href="/list/{{ $item->subProduct->product->product_store_id }}/{{ $item->subProduct->color->id }}">
                                            <img src="{{ $item->subProduct->photos[0]->photo }}" style="width: 100%;" />
                                        </a>

                                        <h4>{{ $item->subProduct->product->description->product_name }}</h4>
                                        <h5>{{ $item->subProduct->product->brand_name }}</h5>

                                        <div style="width: 100%; height: 40px;">
                                            <div class="pull-left" style="margin-right: 25px;">
                                                <h4 style="color: #555;">
                                                    <strike>{{ $item->subProduct->price->final_price }} грн.</strike>
                                                </h4>
                                            </div>

                                            <div class="pull-left">
                                                <h4 style="color: rgb(240, 0, 140);">
                                                    {{ $item->subProduct->price->special_price }} грн.
                                                </h4>
                                            </div>
                                        </div>

                                        <h5>{{ $item->colorsCount }}

                                            @if( $item->colorsCount == 1 )
                                                цвет
                                            @else
                                                цветов
                                            @endif

                                        </h5>

                                    </div>

                                @if( $i == 2 || $i % 3 == 2 )
                                    </div>
                                @endif

                                @php $i++ @endphp

                            @endforeach

                        @endif

                    </div>
                </div>

            </div>

        </div>
    </div>
    </div>

    <input type="hidden" id="sort" value="popularity" />
    <input type="hidden" id="by" value="desc" />
    <input type="hidden" id="category" value="{{ $category }}" />

    <input type="hidden" id="route" value="{{ $route }}" />

    @include('layouts.footer')

    <link rel="stylesheet" type="text/css" href="{{ url('/css/shop/catalog/catalog.css') }}" />
    <script type="text/javascript" src="{{ url('/js/shop/catalog/catalog.js') }}"></script>

@endsection