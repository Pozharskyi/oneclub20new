@extends('layouts.adminPanel')

@section('title') Subproduct @stop

@section('breadcrumb')
    <li><a href={{route('adminTable.users.index', ['user' => $userId])}}>Данные пользователя</a> <span class="divider"></span></li>
    <li><a href={{route('adminPanel.order.index', ['user' => $userId, 'order' => $orderId])}}>
            Данные заказа пользователя
        </a> <span class="divider"></span></li>
    <li class="active">Данные продукта заказа пользователя</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <h2>Sub product info:</h2>
            <ul class="list-group">
                <li class="list-group-item">
                    barcode {{$subProduct->barcode}}
                </li>
                <li class="list-group-item">
                    quantity {{$subProduct->quantity}}
                </li>
                <li class="list-group-item">
                    delivery_days {{$subProduct->delivery_days}}
                </li>

                @foreach($subProduct->photos as $photo)
                    <li class="list-group-item">
                        photo {{$subProduct->photo}}
                    </li>
                @endforeach
                @foreach($subProduct->statusOrderSubProduct as $statusOrderSubProduct)
                    <li class="list-group-item">
                        status {{$statusOrderSubProduct->status}}
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
@endsection