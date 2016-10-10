@extends('layouts.adminPanel')

@section('title') Admin - Products @stop

@section('content')

    <div class="container">
        @if (session()->has('message'))
            <div class="alert alert-info" >{{session('message')}}</div>
        @endif

        <form action="{{ url('/admin/products/create') }}" method="post">

            <div class="text-center">
                <h1>Страница добавления продуктов</h1>
            </div>

            <div class="col-md-2"></div>

            <div class="col-md-8">

                <div class="row">

                        {{ csrf_field() }}

                        <h3 class="lead">Введите описание продукта</h3>
                        <div class="divider"></div>

                        <div class="col-md-4">
                            <label for="product_name">Введите название продукта</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="product_name" name="product_name" class="form-control" required />
                        </div>

                        <div class="col-md-4">
                            <label for="product_description">Введите описание продукта</label>
                        </div>
                        <div class="col-md-8">
                            <textarea id="product_description" name="product_description" rows="5" class="form-control" required></textarea>
                        </div>

                        <div class="col-md-4">
                            <label for="product_composition">Введите состав продукта</label>
                        </div>
                        <div class="col-md-8">
                            <textarea id="product_composition" name="product_composition" rows="5" class="form-control" required></textarea>
                        </div>

                        <div class="col-md-4">
                            <label for="product_delivery_days">Введите время доставки</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" min="0" size="1" id="product_delivery_days" name="product_delivery_days" class="form-control" required />
                        </div>

                        <h3 class="lead">Введите дополнительную информацию о продукте</h3>
                        <div class="divider"></div>

                        <div class="col-md-4">
                            <label for="productSKU">Введите СКУ ( sku )</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="productSKU" name="productSKU" class="form-control" required />
                        </div>

                        <div class="col-md-4">
                            <label for="productGender">Введите категорию продукта</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" id="productGender" name="productGender" required>

                                @foreach( $genders as $gender )

                                    <option value="{{ $gender->id }}">{{ $gender->name }}</option>

                                @endforeach

                            </select>
                        </div>

                        <h3 class="lead">Введите детальное описание</h3>
                        <div class="divider"></div>

                        {{--<div class="col-md-4">--}}
                            {{--<label for="productShopId">Выберите магазин</label>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-8">--}}
                            {{--<select class="form-control" id="productShopId" name="productShopId" required>--}}

                                {{--@foreach( $shops as $shop )--}}

                                    {{--<option value="{{ $shop->id }}">{{ $shop->name }}</option>--}}

                                {{--@endforeach--}}

                            {{--</select>--}}
                        {{--</div>--}}

                        <div class="col-md-4">
                            <label for="productBrand">Выберите бренд</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" id="productBrand" name="productBrand" required>

                                @foreach( $brands as $brand)

                                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>

                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="productCategory">Выберите категорию</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" id="productCategory" name="productCategory" required>

                                @foreach( $categories as $category )

                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>

                                @endforeach

                            </select>
                        </div>

                        {{--<div class="col-md-4">--}}
                            {{--<label for="productSale">Введите номер акции</label>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-8">--}}
                            {{--<select class="form-control" id="productSale" name="productSale" required>--}}

                                {{--@foreach( $sales as $sale )--}}

                                    {{--<option value="{{ $sale->id }}">{{ $sale->sale_title }}</option>--}}

                                {{--@endforeach--}}

                            {{--</select>--}}
                        {{--</div>--}}


                    {{--TODO move to subproduct--}}

                    {{--<h3 class="lead">Введите информацию о ценах</h3>--}}
                        {{--<div class="divider"></div>--}}

                        {{--<div class="col-md-4">--}}
                            {{--<label for="productIndexPrice">Введите цену поставщика</label>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-8">--}}
                            {{--<input type="number" class="form-control" id="productIndexPrice" name="productIndexPrice" required />--}}
                        {{--</div>--}}

                        {{--<div class="col-md-4">--}}
                            {{--<label for="productFinalPrice">Введите цену продажи</label>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-8">--}}
                            {{--<input type="number" class="form-control" id="productFinalPrice" name="productFinalPrice" required />--}}
                        {{--</div>--}}

                        <h3 class="lead">Введите информацию наличии</h3>
                        <div class="divider"></div>

                        <div class="col-md-4">
                            <label for="productStock">Ввыберите наличие предмета</label>
                        </div>
                        <div class="col-md-8">
                            <select id="productStock" class="form-control" name="productStock" required>

                                @foreach( $stocks as $stock )

                                    <option value="{{ $stock->id }}">{{ $stock->stock }}</option>

                                @endforeach

                            </select>
                        </div>




                        {{--<h3 class="lead">Введите дополнительную информацию о продукте</h3>--}}
                        {{--<div class="divider"></div>--}}

                        {{--<div id="sub_products">--}}

                            {{--<div class="add_sub">--}}

                                {{--<div class="row">--}}

                                    {{--<div class="col-md-4">--}}
                                        {{--<label for="subProductBarcode">Введите баркод</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<input type="text" class="form-control" id="subProductBarcode" required name="subProductBarcode_1" />--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-4">--}}
                                        {{--<label for="subProductDelivery">Доставка ( в днях )</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<input type="number" class="form-control" id="subProductDelivery" required name="subProductDelivery_1" />--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-4">--}}
                                        {{--<label for="subProductQuantity">Введите количество</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<input type="number" class="form-control" id="subProductQuantity" required name="subProductQuantity_1" />--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-4">--}}
                                        {{--<label for="subProductSize">Введите размер предмета</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<select id="subProductSize" name="subProductSize_1" class="form-control" required>--}}

                                            {{--@foreach( $sizes as $size )--}}

                                                {{--<option value="{{ $size->id }}">{{ $size->name }}</option>--}}

                                            {{--@endforeach--}}

                                        {{--</select>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-4">--}}
                                        {{--<label for="subProductColor">Введите цвет предмета</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<select id="subProductColor" name="subProductColor_1" class="form-control" required>--}}

                                            {{--@foreach( $colors as $color )--}}

                                                {{--<option value="{{ $color->id }}">{{ $color->name }}</option>--}}

                                            {{--@endforeach--}}

                                        {{--</select>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-4">--}}
                                        {{--<label for="subProductAdditionalPrice">Введите наценку за предмет</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<input type="number" class="form-control" id="subProductAdditionalPrice" required name="subProductAdditionalPrice_1" />--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-4">--}}
                                        {{--<label for="subProductPhoto">Выберите фотографии</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8" id="photos_1">--}}

                                    {{--</div>--}}

                                {{--</div>--}}

                            {{--</div>--}}

                        {{--</div>--}}

                        {{--<input type="hidden" id="subQuantity" value="1" />--}}
                        {{--<button style="margin-top: 15px;" type="button" onclick="addSubProduct();" class="btn btn-default">Добавить информацию</button>--}}

                </div>

                <div class="text-center" style="margin: 35px 0 50px 0;">
                    <button class="btn btn-primary">Сохранить</button>
                </div>

            </div>

        </form>

        <div class="col-md-2"></div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/panel/products/read.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/admin/products/read.css') }}" />

@endsection