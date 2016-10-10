@extends('layouts.adminPanel')

@section('title') Admin - Products @stop

@section('content')

    <div class="container">
        @if (session()->has('message'))
            <div class="alert alert-info" >{{session('message')}}</div>
        @endif

        <form action="{{ url('/admin/products/update', ['product_id' => $product->id]) }}" method="post">

            {{ method_field('PUT') }}

            <div class="text-center">
                <h1>Страница обновления продукта</h1>
            </div>

            <div class="col-md-2"></div>

            <div class="col-md-8">

                <div class="row">

                    {{ csrf_field() }}

                    <h3 class="lead">Обновление описания продукта</h3>
                    <div class="divider"></div>

                    <div class="col-md-4">
                        <label for="product_name">Измените название продукта</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="product_name" name="product_name"
                               class="form-control" required value="{{$product->description->product_name}}" />
                    </div>

                    <div class="col-md-4">
                        <label for="product_description">Измените описание продукта</label>
                    </div>
                    <div class="col-md-8">
                        <textarea id="product_description" name="product_description" rows="5"
                                  class="form-control" required>{{$product->description->product_description}}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label for="product_composition">Измените состав продукта</label>
                    </div>
                    <div class="col-md-8">
                        <textarea id="product_composition" name="product_composition" rows="5"
                                  class="form-control" required >{{$product->description->product_composition}}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label for="product_delivery_days">Измените время доставки</label>
                    </div>
                    <div class="col-md-8">
                        <input type="number" min="0" size="1" id="product_delivery_days" name="product_delivery_days"
                               class="form-control" required value="{{$product->description->product_delivery_days}}" />
                    </div>

                    <h3 class="lead">Обновление дополнительной информации о продукте</h3>
                    <div class="divider"></div>

                    <div class="col-md-4">
                        <label for="productSKU">Измените СКУ ( sku )</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="productSKU" name="productSKU"
                               class="form-control" required value="{{$product->sku}}" />
                    </div>

                    <div class="col-md-4">
                        <label for="productGender">Измените категорию продукта</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" id="productGender" name="productGender" required>

                            @foreach( $genders as $gender )
                                <option @if($product->gender->id == $gender->id) selected @endif
                                value="{{ $gender->id }}">{{ $gender->name }}</option>

                            @endforeach

                        </select>
                    </div>

                    <h3 class="lead">Обновление детального описания</h3>
                    <div class="divider"></div>

                    <div class="col-md-4">
                        <label for="productBrand">Измените бренд</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" id="productBrand" name="productBrand" required>

                            @foreach( $brands as $brand)

                                <option @if($product->brand->id == $brand->id) selected @endif
                                value="{{ $brand->id }}">{{ $brand->brand_name }}</option>

                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="productCategory">Измените категорию</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" id="productCategory" name="productCategory" required>

                            @foreach( $categories as $category )

                                <option @if($product->category->id == $category->id) selected @endif
                                value="{{ $category->id }}">{{ $category->category_name }}</option>

                            @endforeach

                        </select>
                    </div>


                    <h3 class="lead">Обновление информации о наличии</h3>
                    <div class="divider"></div>

                    <div class="col-md-4">
                        <label for="productStock">Измените наличие предмета</label>
                    </div>
                    <div class="col-md-8">
                        <select id="productStock" class="form-control" name="productStock" required>

                            @foreach( $stocks as $stock )
                                <option @if($product->stock->id == $stock->id) selected @endif
                                value="{{ $stock->id }}">{{ $stock->stock }}</option>

                            @endforeach

                        </select>
                    </div>

                </div>

                <div class="text-center" style="margin: 35px 0 50px 0;">
                    <button class="btn btn-primary">Обновить</button>
                </div>

            </div>

        </form>

        <div class="col-md-2"></div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/panel/products/read.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/admin/products/read.css') }}" />

@endsection