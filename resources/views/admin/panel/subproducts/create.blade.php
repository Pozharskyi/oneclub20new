@extends('layouts.adminPanel')

@section('title') Subproduct @stop

@section('breadcrumb')

    <li class="active">Создание нового субпродуктв</li>
@endsection

@section('content')
    <div class="row">
        @if (session()->has('message'))
            <div class="alert alert-info" >{{session('message')}}</div>
        @endif
        <div class="col-md-6">
            <form id="createSubProduct" method="POST" action="{{route('AdminPanel.subproduct.store')}}">
                {{ csrf_field() }}
                <h2>Создать субпродукт</h2>
                <div class="form-group{{ $errors->has('barcode') ? ' has-error' : ''}}">
                    barcode:
                    <input id="barcode" type="text" class="form-control" name="barcode" value='{{ old('barcode') }}'>
                    @if ($errors->has('barcode'))
                        <span class="help-block">
                        <strong>{{ $errors->first('barcode') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('markup_price') ? ' has-error' : ''}}">
                    markup_price:
                    <input id="markup_price" type="number" min="0" step="0.01" class="form-control" name="markup_price"
                           value='{{ old('markup_price') }}'>
                    @if ($errors->has('markup_price'))
                        <span class="help-block">
                        <strong>{{ $errors->first('markup_price') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('quantity') ? ' has-error' : ''}}">
                    quantity:
                    <input id="markup_price" type="number" min="0" step="1" class="form-control" name="quantity"
                           value='{{ old('quantity') }}'>
                    @if ($errors->has('quantity'))
                        <span class="help-block">
                        <strong>{{ $errors->first('quantity') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('delivery_days') ? ' has-error' : ''}}">
                    delivery_days:
                    <input id="delivery_days" type="number" min="0" step="1" class="form-control" name="delivery_days"
                           value='{{ old('delivery_days') }}'>
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
                            <option value="{{$size->id}}">{{$size->name}}</option>
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
                            <option value="{{$color->id}}">{{$color->name}}</option>
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
                            <option value="{{$product->id}}">{{$product->id}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('product'))
                        <span class="help-block">
                        <strong>{{ $errors->first('product')}}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Создать
                        субпродукт
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop