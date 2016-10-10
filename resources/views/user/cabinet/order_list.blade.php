@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-sm-4 col-md-3">
        @include('user.cabinet.cabinet_menu')
    </div>
    <div class="col-xs-12 col-sm-8 col-md-9">
    @if(count($data) != 0)
        <div class="col-xs-12 col-sm-10 col-md-10 well panel-heading">
            <div class="col-xs-3 col-sm-3 col-md-3">Номер заказа</div>
            <div class="col-xs-3 col-sm-3 col-md-3">Дата оформления</div>
            <div class="col-xs-2 col-sm-2 col-md-2">Сумма</div>
            <div class="col-xs-2 col-sm-2 col-md-2">Статус</div>
            <div class="col-xs-2 col-sm-2 col-md-2"></div>
        </div>
        @foreach($data as $order)
        <div class="col-xs-12 col-sm-10 col-md-10 well well-lg">
            <div class="col-xs-3 col-sm-3 col-md-3">
                <a href="/cabinet/orders/{{ $order->id }}">
                    {{ $order->public_order_id }}
                </a>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">{{ $order->created_at }}</div>
            <div class="col-xs-2 col-sm-2 col-md-2">{{ $order->total_sum }} грн.</div>
            <div class="col-xs-2 col-sm-2 col-md-2">{{ $order->statusOrderSubProduct[0]->user_status }}</div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                @if($order->statusOrderSubProduct[0]->id < 10)
                    <a>Отменить</a>
                @endif
            </div>
        </div>
        @endforeach
        <div class="col-xs-12 col-sm-10 col-md-10">
            @if(count($data->render()) > 0)
            {{ $data->render() }}
            @endif
        </div>
    @else
        <div class="col-xs-12 col-sm-10 col-md-10">
            Заказы отсутствуют
        </div>
    @endif
    </div>
@endsection