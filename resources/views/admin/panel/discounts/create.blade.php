@extends('layouts.adminPanel')

@section('title') Discounts @stop

@section('breadcrumb')
    <li class="active">Создать дискаунт</li>
@endsection

@section('content')

        <div class="col-md-6">
            <form id="createDiscount" method="POST" action="{{route('AdminPanel.discounts.store')}}">
                {{ csrf_field() }}
                <h2>Создать дискаунт</h2>
                <div class="form-group{{ $errors->has('discount_id') ? ' has-error' : ''}}">

                    <label for="discount_id">Введите уникальный id дискаунта:</label>

                    <input id="discount_id" type="text" class="form-control" name="discount_id" value=''>
                    @if ($errors->has('discount_id'))
                        <span class="help-block">
                        <strong>{{ $errors->first('discount_id') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('status') ? ' has-error' : ''}}">

                    <label for="status">Выберите статус:</label>

                    <select id="status" name="status" size="1" class="form-control">
                        <option value="Активный">Активный</option>
                        <option value="Не активный">Не активный</option>
                    </select>
                    @if ($errors->has('status'))
                        <span class="help-block">
                        <strong>{{ $errors->first('status')}}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('type') ? ' has-error' : ''}}">

                    <label for="type">Выберите тип:</label>

                    <select id="type" name="type" size="1" class="form-control">
                        <option value="money">Грн</option>
                        <option value="percent">%</option>
                    </select>
                    @if ($errors->has('type'))
                        <span class="help-block">
                        <strong>{{ $errors->first('type')}}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('discount_amount') ? ' has-error' : ''}}">

                    <label for="discount_amount">Введите величину скидки:</label>

                    <input id="discount_amount" type="number" step="0.01" class="form-control" name="discount_amount"
                           value=''>
                    @if ($errors->has('discount_amount'))
                        <span class="help-block">
                        <strong>{{ $errors->first('discount_amount') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('active_from') ? ' has-error' : ''}}">

                    <label for="active_from">Введите начало действия скидки:</label>

                    <input id="active_from" type="date" class="form-control" name="active_from" value=''>
                    @if ($errors->has('active_from'))
                        <span class="help-block">
                        <strong>{{ $errors->first('active_from') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('active_to') ? ' has-error' : ''}}">

                    <label for="active_to">Введите завершение действия скидки:</label>

                    <input id="active_to" type="date" class="form-control" name="active_to" value=''>
                    @if ($errors->has('active_to'))
                        <span class="help-block">
                        <strong>{{ $errors->first('active_to') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('comment') ? ' has-error' : ''}}">

                    <label for="comment">Введите комментарий:</label>

                    <input id="comment" type="text" class="form-control" name="comment" value=''>
                    @if ($errors->has('comment'))
                        <span class="help-block">
                        <strong>{{ $errors->first('comment') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('rule') ? ' has-error' : ''}}">

                    <label for="rule">Введите название правила скидки:</label>

                    <input id="rule" type="text" class="form-control" name="rule" value=''>
                    @if ($errors->has('rule'))
                        <span class="help-block">
                        <strong>{{ $errors->first('rule') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('auto') ? ' has-error' : ''}}">

                    <label for="auto"> Выберите вид скидки:</label>

                    <select id="auto" name="auto" size="1" class="form-control">
                        <option value="0">Не автоматическая</option>
                        <option value="1">Автоматическая</option>
                    </select>
                    @if ($errors->has('auto'))
                        <span class="help-block">
                        <strong>{{ $errors->first('auto')}}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('min_basket_sum') ? ' has-error' : ''}}">

                    <label for="min_basket_sum">Введите минимальную сумму в корзине:</label>

                    <input id="min_basket_sum" type="number" step="0.01" class="form-control" name="min_basket_sum"
                           value=''>
                    @if ($errors->has('min_basket_sum'))
                        <span class="help-block">
                        <strong>{{ $errors->first('min_basket_sum') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('max_basket_sum') ? ' has-error' : ''}}">

                    <label for="max_basket_sum">Введите максимальную сумму в корзине:</label>

                    <input id="max_basket_sum" type="number" step="0.01" class="form-control" name="max_basket_sum"
                           value=''>
                    @if ($errors->has('max_basket_sum'))
                        <span class="help-block">
                        <strong>{{ $errors->first('max_basket_sum') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('subproduct_amount_from') ? ' has-error' : ''}}">

                    <label for="subproduct_amount_from">Введите количество субпродуктов в корзине:</label>

                    <input id="subproduct_amount_from" type="number" step="1" class="form-control"
                           name="subproduct_amount_from" value=''>
                    @if ($errors->has('subproduct_amount_from'))
                        <span class="help-block">
                        <strong>{{ $errors->first('subproduct_amount_from') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('purchase_number') ? ' has-error' : ''}}">

                    <label for="purchase_number">Введите номер покупки:</label>

                    <input id="purchase_number" type="number" step="1" class="form-control" name="purchase_number"
                           value=''>
                    @if ($errors->has('purchase_number'))
                        <span class="help-block">
                        <strong>{{ $errors->first('purchase_number') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('deliveryTypes') ? ' has-error' : ''}}">

                    <label for="deliveryTypes">Выберите тип доставки:</label>

                    <select multiple id="deliveryTypes" name="deliveryTypes[]" class="form-control">
                        @foreach($deliveryTypes as $deliveryType)
                            <option value="{{$deliveryType->id}}">{{$deliveryType->delivery_type}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('deliveryTypes'))
                        <span class="help-block">
                        <strong>{{ $errors->first('deliveryTypes')}}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('paymentTypes') ? ' has-error' : ''}}">

                    <label for="paymentTypes">Выберите тип оплаты:</label>

                    <select multiple id="paymentTypes" name="paymentTypes[]" class="form-control">
                        @foreach($paymentTypes as $paymentType)
                            <option value="{{$paymentType->id}}">{{$paymentType->payment_type}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('paymentTypes'))
                        <span class="help-block">
                        <strong>{{ $errors->first('paymentTypes')}}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('max_used_all') ? ' has-error' : ''}}">

                    <label for="max_used_all"> Введите максимальное количество использований скидки:</label>

                    <input id="max_used_all" type="number" step="1" class="form-control" name="max_used_all"
                           value=''>
                    @if ($errors->has('max_used_all'))
                        <span class="help-block">
                        <strong>{{ $errors->first('max_used_all') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('max_used_user') ? ' has-error' : ''}}">

                    <label for="max_used_user">Введите максимальное количество использований скидки для одного пользователя:</label>
                    <input id="max_used_user" type="number" step="1" class="form-control" name="max_used_user"
                           value=''>
                    @if ($errors->has('max_used_user'))
                        <span class="help-block">
                        <strong>{{ $errors->first('max_used_user') }}</strong>
                    </span>
                    @endif
                </div>

                {{--<div class="radio">--}}
                    {{--<label><input type="radio" name="coupon_generate">Включить автогенерацию купонов кодов</label>--}}
                {{--</div>--}}
                <div class="form-group">

                    <label for="coupon_generate">Включить автогенерацию кодов купонов</label>

                    <input type="checkbox" name="coupon_generate" class="checkbox-inline" value="on" />
                </div>

                <div class="form-group{{ $errors->has('coupon_code_name') ? ' has-error' : ''}}">

                    <label for="coupon_code_name"> Введите код купона:</label>
                    <input id="coupon_code_name" type="text" class="form-control" name="coupon_code_name" value=''>
                    @if ($errors->has('coupon_code_name'))
                        <span class="help-block">
                        <strong>{{ $errors->first('coupon_code_name') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('coupon_amount') ? ' has-error' : ''}}">
                    <label for="coupon_amount"> Количество купон кодов:</label>
                    <input id="coupon_amount" type="number" step="1" class="form-control" name="coupon_amount"
                           value=''>
                    @if ($errors->has('coupon_amount'))
                        <span class="help-block">
                        <strong>{{ $errors->first('coupon_amount') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="usersCategoryIds[]">Выберете категории пользователей</label>
                </div>
                @foreach($usersCategories as $usersCategory)
                    <div class="checkbox-inline">
                        <label><input type="checkbox" name="usersCategoryIds[]"
                                      value="{{$usersCategory->id}}">{{$usersCategory->category}}
                        </label>
                    </div>
                @endforeach

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Создать
                        дискаунт
                    </button>
                </div>
            </form>

    </div>
    <script>
        $('#type').change(function () {
            if ($(this).val() == 'percent') {
                $('#discount_amount').attr({
                    "max": 100        // max for percent
                });
            } else {
                $('#discount_amount').removeAttr("max");
            }
        });
    </script>
@stop