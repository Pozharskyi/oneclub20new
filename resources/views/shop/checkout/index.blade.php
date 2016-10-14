@extends('layouts.app')

@section('content')

    <div class="container">

        <form id="checkout_form" action="{{ url('/list/order/save') }}" method="post">

            {{ csrf_field() }}

            <h1>Оформление заказа</h1>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-6">

                    <h2>1.Контактные данные</h2>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="f_name">Имя</label>
                        </div>
                        <div class="col-md-7">
                            <input id="f_name" value="{{ $user->f_name }}" type="text" class="form-control"
                                   name="f_name" required/>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="l_name">Фамилия</label>
                        </div>
                        <div class="col-md-7">
                            <input id="l_name" value="{{ $user->l_name }}" type="text" class="form-control"
                                   name="l_name" required/>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="city">Город</label>
                        </div>
                        <div class="col-md-7">
                            <select id="city" name="city" class="form-control" required>
                                <option value="Киев">Киев</option>
                            </select>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="cell">Мобильный телефон</label>
                        </div>
                        <div class="col-md-7">
                            <input id="cell" value="{{ $user->phone }}" type="text" class="form-control" name="cell"
                                   required/>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="email">Эл. почта</label>
                        </div>
                        <div class="col-md-7">
                            <input id="email" value="{{ $user->email }}" type="text" class="form-control" name="email"
                                   required/>
                        </div>
                    </div>

                    <div style="width: 100%; height: 1px; background-color: rgb(240, 0, 140); margin: 20px 0 20px 0;"></div>

                    <h2>2. Выбор способов доставки</h2>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="email">Доставка</label>
                        </div>
                        <div class="col-md-7">

                            @foreach( $delivery_types as $type )

                                <input type="radio" name="delivery_type" value="{{ $type->id }}"
                                       required/>{{ $type->delivery_type }}
                                <br/>
                            @endforeach

                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="delivery_f_name">Имя</label>
                        </div>
                        <div class="col-md-7">

                            <input type="text" class="form-control" name="delivery_f_name" id="delivery_f_name"
                                   value="{{ $user->f_name }}" required/>

                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="delivery_l_name">Фамилия</label>
                        </div>
                        <div class="col-md-7">

                            <input type="text" class="form-control" name="delivery_l_name" id="delivery_l_name"
                                   value="{{ $user->l_name }}" required/>

                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="delivery_cell">Телефон</label>
                        </div>
                        <div class="col-md-7">

                            <input type="text" class="form-control" name="delivery_cell" id="delivery_cell"
                                   value="{{ $user->phone }}" required/>

                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="delivery_cell">Адрес доставки</label>
                        </div>
                        <div class="col-md-7">

                            <input type="text" class="form-control" name="delivery_address" id="delivery_address"
                                   required/>

                        </div>
                    </div>

                    <div style="width: 100%; height: 1px; background-color: rgb(240, 0, 140); margin: 20px 0 20px 0;"></div>

                    <h2>3. Выбор способа оплаты</h2>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="payment_type">Оплата</label>
                        </div>
                        <div class="col-md-7">

                            @foreach( $payment_types as $type )

                                <input type="radio" name="payment_type" value="{{ $type->id }}"
                                       required/>{{ $type->payment_type }}
                                <br/>
                            @endforeach

                        </div>

                        {{--<span class="input-group-addon">Списать с личного баланса </span>--}}
                        {{--<span class="input-group-addon">--}}
                        <div class="col-md-5">
                            <label for="useBalance">Списать с личного баланса</label>
                        </div>
                        <div class="col-md-7">
                            <input type="checkbox" id="useBalance" name="useBalance" value="on"
                                   onchange="toggleBalance(this)">
                        </div>
                        {{--</span>--}}

                    </div>

                    <div style="width: 100%; height: 1px; background-color: rgb(240, 0, 140); margin: 20px 0 20px 0;"></div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-5">
                            <label for="comment">Комментарий к заказу</label>
                        </div>
                        <div class="col-md-7">

                            <textarea class="form-control" name="comment" id="comment" rows="6"></textarea>

                        </div>
                    </div>

                </div>
                <div class="col-md-1"></div>

                <div class="col-md-4">

                    <div id="bonusSection" style="width: 100%; border: 2px solid #f0ad4e; padding: 0 15px 15px 15px;">

                        <h2>Бонусы</h2>

                        <h4>
                            Вы можете использовать <span id="current_bonuses">{{ $bonuses }}</span> бонусов <br/>
                            1 бонус = 1грн
                        </h4>

                        <input type="range" min="0" max="{{ $bonuses }}" style="width: 100%;" id="bonuses" value="0"/>

                        <h4>
                            Максимальное количетсво бонусов, которые вы можете использовать {{ $bonuses }}
                        </h4>

                        <input type="number" style="width: 70px; text-align: center;" name="bonuses" id="bonuses_val"
                               value="0" disabled/> = <span id="bonuses_uah">0</span> грн

                        <h5 style="color: rgb(240, 0, 140);" id="bonuses_set"></h5>

                        <div class="text-center" style="margin: 25px 0 25px 0; height: 25px;">

                            <button type="button" onclick="resetPointsToOrder();" class="btn btn-default pull-left">
                                Отменить
                            </button>

                            <button type="button" onclick="getPointsToOrder();" class="btn btn-primary pull-right">
                                Применить
                            </button>

                            <input type="hidden" id="bonuses_count" name="bonuses_used" value="0"/>
                            <input type="hidden" id="bonuses_max" name="max_bonuses" value="{{ $bonuses }}"/>

                        </div>

                    </div>

                    <div style="width: 100%; border: 2px solid #f0ad4e; padding: 0 15px 15px 15px; margin-top: 25px;">

                        <h2>Код скидки</h2>

                        <h5>Введите код скидки, если он у вас есть</h5>

                        <input type="text" class="form-control" id="discount"/>

                        <div id="discount_status"></div>

                        <button type="button" id="discountsButton" onclick="validateDiscount();"
                                style="margin: 25px 0 25px 0;" class="form-control btn btn-danger">Использовать код
                            скидки
                        </button>

                        <input type="hidden" id="discountId" name="discount" value=""/>
                        <input type="hidden" id="total_price" name="total_price" value="{{ $products->total_price }}"/>
                        <input type="hidden" id="origin_price" name="origin_price"
                               value="{{ $products->total_price }}"/>

                        {{--<div class=""></div>--}}
                        <h5>У вас на личном балансе</h5>
                        <div id="balance">{{$balance}} </div>
                        <br/>
                        <input type="radio" name="discount_bonus" value="discount" onclick="discountClicked()"
                               />Использовать скидку
                        <br/>
                        <input type="radio" name="discount_bonus" value="bonus" onclick="bonusClicked()"
                               />Использовать бонусы
                        <br/>
                        <input type="radio" name="discount_bonus" value="auto_discount" onclick="autoDiscountClicked()"
                               />Использовать автоматическую скидку
                        <br/>
                        <div class="hidden" id="balance_origin">{{$balance}}</div>

                    </div>

                    <div style="width: 100%; border: 2px solid #f0ad4e; padding: 0 15px 15px 15px; margin-top: 25px;">

                        <h2>Итого</h2>

                        <h4>Количество товаров: {{ $products->total_quantity }}шт.</h4>

                        <h4>Сумма заказа: <b>
                                <span id="total">

                                {{ $products->total_price }}

                                </span> грн</b></h4>
                        {{--<span id="total_origin" class="hidden">{{ $products->total_price }}</span>--}}
                        <div id="payment_left">
                            <h4>Остаток к оплате: <b>
                                    <span>
                                      {{ $products->total_price }}
                                </span>
                                </b></h4>
                        </div>

                        <h4>Стоимость доставки: Бесплатно</h4>

                        <button class="btn btn-primary form-control" style="margin: 15px 0 5px 0;">
                            Заказ подтверждаю
                        </button>

                        <a href="{{ url('/basket') }}">
                            <button type="button" class="btn btn-default form-control" style="margin: 15px 0 15px 0;">
                                Редактировать заказ
                            </button>
                        </a>

                    </div>

                </div>

            </div>

            <div class="text-center" style="margin: 100px 0 100px 0;">

                <button class="btn btn-primary">Заказ подтверждаю</button>

            </div>

        </form>

    </div>

    @include('layouts.footer')

    <script src="{{ url('/js/shop/checkout/checkout.js') }}"></script>
    <script src="{{ url('/js/shop/basic/discount.js') }}"></script>
    <script src="{{ url('/js/shop/basic/balance.js') }}"></script>
    <script src="{{ url('/js/shop/basic/discount_bonus_radio.js') }}"></script>
    <style>
        #payment_left {
            display: none;
        }

        #bonusSection {
            display: none;
        }
    </style>
@endsection