@extends('layouts.adminPanel')

@section('title') Subproduct @stop

@section('breadcrumb')

    <li class="active">Редактирование субпродуктв</li>
@endsection

@section('content')
    <div class="row">
        @if (session()->has('message'))
            <div class="alert alert-info" >{{session('message')}}</div>
        @endif
        <div class="col-md-6">
            <form id="createSubProduct" method="POST" action="{{route('AdminPanel.subproduct.update',
            ['product' => $product->id, 'subproduct' => $subProduct->id])}}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <h2>Редактировать субпродукт</h2>
                <div class="form-group{{ $errors->has('barcode') ? ' has-error' : ''}}">
                    barcode:
                    <input id="barcode" type="text" class="form-control" name="barcode" value='{{$subProduct->barcode}}'>
                    @if ($errors->has('barcode'))
                        <span class="help-block">
                        <strong>{{ $errors->first('barcode') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('markup_price') ? ' has-error' : ''}}">
                    markup_price:
                    <input id="markup_price" type="number" min="0" step="0.01" class="form-control" name="markup_price"
                           value='{{$subProduct->markup_price}}'>
                    @if ($errors->has('markup_price'))
                        <span class="help-block">
                        <strong>{{ $errors->first('markup_price') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('quantity') ? ' has-error' : ''}}">
                    quantity:
                    <input id="markup_price" type="number" min="0" step="1" class="form-control" name="quantity"
                           value='{{$subProduct->quantity}}'>
                    @if ($errors->has('quantity'))
                        <span class="help-block">
                        <strong>{{ $errors->first('quantity') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('delivery_days') ? ' has-error' : ''}}">
                    delivery_days:
                    <input id="delivery_days" type="number" min="0" step="1" class="form-control" name="delivery_days"
                           value='{{$subProduct->delivery_days}}'>
                    @if ($errors->has('delivery_days'))
                        <span class="help-block">
                        <strong>{{ $errors->first('delivery_days') }}</strong>
                    </span>
                    @endif
                </div>


                <div class="form-group{{ $errors->has('size') ? ' has-error' : ''}}">
                    size:
                    <select id="size" name="size" class="form-control">
                        @foreach($sizes as $size)
                            <option @if($subProduct->dev_product_size_id == $size->id) selected @endif value="{{$size->id}}">{{$size->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('size'))
                        <span class="help-block">
                        <strong>{{ $errors->first('size')}}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('color') ? ' has-error' : ''}}">
                    size:
                    <select id="color" name="color" class="form-control">
                        @foreach($colors as $color)
                            <option  @if($subProduct->dev_product_color_id == $color->id) selected @endif value="{{$color->id}}">{{$color->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('color'))
                        <span class="help-block">
                        <strong>{{ $errors->first('color')}}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('product') ? ' has-error' : ''}}">
                    product:
                    <select id="product" name="product" class="form-control">
                        @foreach($products as $product)
                            <option @if($subProduct->dev_product_index_id == $product->id) selected @endif value="{{$product->id}}">{{$product->id}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('product'))
                        <span class="help-block">
                        <strong>{{ $errors->first('product')}}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Обновить
                        субпродукт
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop