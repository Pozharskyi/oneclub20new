@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-sm-2 col-md-2">
        @include('user.cabinet.cabinet_menu');
    </div>
    <div class="col-xs-12 col-sm-10 col-md-10">
        <h3>Бонусы: @if(count($user_bonuses_amount) != 0)
                {{ $user_bonuses_amount[0]->bonuses_amount }}
        @else
            0
        @endif</h3>
        @if(count($user_bonuses_loging) != 0)
            <div class="col-xs-12 col-sm-10 col-md-10 panel-heading">
                <h5>Бонусы</h5>
                <div class="col-xs-4 col-sm-4 col-md-4">Кол-во бонусов</div>
                <div class="col-xs-4 col-sm-4 col-md-4"></div>
                <div class="col-xs-4 col-sm-4 col-md-4">Дата</div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-10 well well-small">
                @foreach($user_bonuses_loging as $bonusLoging)

                    <div class="col-xs-12 col-sm-12 col-md-12 well {{ $bonusLoging['type'] }}">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            {{ $bonusLoging['type'] == 'in' ? '+' : '-' }}{{ $bonusLoging['amount'] }}
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            @if( isset($bonusLoging['comment']['order_id']))
                                Заказ № <a href="/cabinet/orders/{{ $bonusLoging['comment']['order_id'] }}">{{ $bonusLoging['comment']['public_order_id'] }}</a>
                            @else
                                {{ $bonusLoging['comment'] }}
                            @endif
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            {{ $bonusLoging['type'] == 'in' ? 'Зачислено:' : 'Использовано:' }} {{ $bonusLoging['created_at'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <style>
            .in{background-color: #5cb85c;}
            .out{background-color: #cbb956;}
        </style>


        @if(count($user_discount_log) != 0)
            <div class="col-xs-12 col-sm-10 col-md-10 panel-heading">
                <h5>Использование купонов:</h5>
                <div class="col-xs-3 col-sm-3 col-md-3">№ Заказа</div>
                <div class="col-xs-3 col-sm-3 col-md-3">№ купона</div>
                <div class="col-xs-3 col-sm-3 col-md-3">Скидка</div>
                <div class="col-xs-3 col-sm-3 col-md-3">Дата</div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-10 well well-small">
                @foreach($user_discount_log as $discountLog)
                    <div class="col-xs-12 col-sm-12 col-md-12 well">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <a href="/cabinet/orders/{{ $discountLog->id }}">{{ $discountLog->public_order_id }}</a>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">{{ $discountLog->discount['discount_id'] }}</div>
                        <div class="col-xs-3 col-sm-3 col-md-3">{{ $discountLog->discount['discount_amount'] }}</div>
                        <div class="col-xs-3 col-sm-3 col-md-3">{{ $discountLog->created_at }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection