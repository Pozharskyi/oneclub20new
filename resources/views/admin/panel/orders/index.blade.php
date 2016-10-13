@extends('layouts.adminPanel')

@section('title') Users @stop

@section('breadcrumb')
    <li><a href={{route('adminTable.users.searchUser')}}>Выбор пользователя</a> <span class="divider"></span></li>

    <li><a href={{route('adminTable.users.index', ['user' => $userId])}}>Данные пользователя</a> <span
                class="divider"></span></li>

    <li class="active">Данные заказа пользователя</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <form id="updateOrderStatusForm" class="form-inline" action="#">
                <div class="form-group">
                    Статус заказа:
                    @if(!($order->statusOrderSubProduct))
                        <input class="hidden" id="orderStatusId" value={{$order->statusOrderSubProduct[0]->id}}>
                        <input id="order_status" type="text" class="form-control" name="order_status"
                               value="{{$order->statusOrderSubProduct[0]->user_status}}">
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Обновить статус заказа
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div id="updateOrder">
                <form id="updateOrderForm" action="#">
                    <h2>Обновить заказ</h2>
                    <input class="hidden" id="orderId" value={{$order->id}}>

                    <div class="form-group">
                        #:
                        <input id="public_order_id" type="text" class="form-control" name="public_order_id"
                               value="{{$order->public_order_id}}">
                    </div>

                    <div class="form-group">
                        Общая сумма:
                        <input id="total_sum" type="number" step="0.01" class="form-control" name="total_sum"
                               value="{{$order->total_sum}}">

                    </div>

                    <div class="form-group">
                        Общее количество:
                        <input id="total_quantity" type="number" class="form-control" name="total_quantity"
                               value="{{$order->total_quantity}}">

                    </div>

                    <div class="form-group">
                        Комментарий:
                        <input id="comment" type="text" class="form-control" name="comment"
                               value="{{$order->comment}}">

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Обновить заказ
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-md-3">
            <div id="updateOrderDelivery">
                <form id="updateOrderDeliveryForm" action="#">
                    <h2>Обновить доставку</h2>
                    <input class="hidden" id="deliveryId" value="{{$order->orderDelivery->id}}">

                    <div class="form-group">
                        Тип доставки:
                        <select id="delivery_type_id" name="delivery_type_id" size="1" class="form-control">
                            @foreach($deliveryTypes as $deliveryType)
                                @if($deliveryType->id == $order->orderDelivery->delivery_type_id)
                                    <option selected
                                            value="{{$deliveryType->id}}">{{$deliveryType->delivery_type}}</option>
                                @else
                                    <option value="{{$deliveryType->id}}">{{$deliveryType->delivery_type}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        Имя:
                        <input id="delivery_f_name" type="text" class="form-control" name="delivery_f_name"
                               value="{{$order->orderDelivery->delivery_f_name}}">

                    </div>

                    <div class="form-group">
                        Фамилия:
                        <input id="delivery_l_name" type="text" class="form-control" name="delivery_l_name"
                               value="{{$order->orderDelivery->delivery_l_name}}">

                    </div>

                    <div class="form-group">
                        Телефон:
                        <div class="form-inline">
                            <label>+380</label>
                            <input id="delivery_phone" type="text" class="form-control" name="delivery_phone"
                                   value="{{$order->orderDelivery->delivery_phone}}">
                        </div>
                    </div>

                    <div class="form-group">
                        Адресс:
                        <input id="delivery_address" type="text" class="form-control" name="delivery_address"
                               value="{{$order->orderDelivery->delivery_address}}">

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Обновить доставку
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-3">
            <div id="selectSubProducts">
                <h2>Sub products</h2>
                <ul class="list-group">
                    <br>
                    @foreach($order->subProducts as $subProduct)
                        <li class="list-group-item">
                            <a href="/admin/users/{{$order->user_id}}/orders/{{$order->id}}/subproducts/{{$subProduct->id}}">
                                {{$subProduct->barcode}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div id="updateOrderContactDetails">
                <form id="updateOrderContactDetailsForm" action="#">
                    <h2>Обновить контактную информацию</h2>
                    <input class="hidden" id="contactDetailsId"
                           value="{{$order->orderContactDetails->id}}">

                    <div class="form-group">
                        Имя:
                        <input id="f_name" type="text" class="form-control" name="f_name"
                               value="{{$order->orderContactDetails->f_name}}">
                    </div>

                    <div class="form-group">
                        Фамилия:
                        <input id="l_name" type="text" class="form-control" name="l_name"
                               value="{{$order->orderContactDetails->l_name}}">

                    </div>

                    <div class="form-group">
                        Город:
                        <input id="city" type="text" class="form-control" name="city"
                               value="{{$order->orderContactDetails->city}}">

                    </div>

                    <div class="form-group">
                        Телефон:
                        <div class="form-inline">
                            <label>+380</label>
                            <input id="cell" type="text" class="form-control" name="cell"
                                   value="{{$order->orderContactDetails->cell}}">
                        </div>
                    </div>

                    <div class="form-group">
                        Email:
                        <input id="email" type="text" class="form-control" name="email"
                               value="{{$order->orderContactDetails->email}}">

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Обновить контактную информацию
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-3">
            <div id="updateOrderPayment">
                <form id="updateOrderPaymentForm" action="#">
                    <h2>Обновить тип оплаты</h2>

                    <div class="form-group">
                        Тип оплаты:
                        <select id="payment_type" name="payment_type" size="1" class="form-control">
                            @foreach($paymentTypes as $paymentType)
                                @if($paymentType->id == $order->orderPaymentType->id)
                                    <option selected
                                            value="{{$paymentType->id}}">{{$paymentType->payment_type}}</option>
                                @else
                                    <option value="{{$paymentType->id}}">{{$paymentType->payment_type}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Обновить тип оплаты
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-3">
            @if(!empty($order->discount))
                <div id="updateOrderDiscount">
                    <h2>Обновить Discount</h2>
                    <dl class="dl-horizontal">
                        <dt>Величина скидки</dt>
                        <dd id="discount_amount">{{$order->discount->discount_amount}}
                            @if($order->discount->type == 'money') грн @else % @endif</dd>

                        <dt>Активна от</dt>
                        <dd id="active_from">{{$order->discount->active_from->format('d/m/Y')}}</dd>

                        <dt>Активна до</dt>
                        <dd id="active_to">{{$order->discount->active_to->format('d/m/Y')}}</dd>

                        <dt>Комеентарий к скидке</dt>
                        <dd id="discount_amount">{{$order->discount->comment}}</dd>
                        <dt>Правило скидки</dt>
                        <dd id="discount_amount">{{$order->discount->rule}}</dd>

                        @if(! empty($order->discount->min_basket_sum))
                            <dt>Минимальная сумма корзины</dt>
                            <dd id="discount_amount">{{$order->discount->min_basket_sum}}</dd>
                        @endif

                        @if(! empty($order->discount->max_basket_sum))
                            <dt>Максимальная сумма корзины</dt>
                            <dd id="discount_amount">{{$order->discount->max_basket_sum}}</dd>
                        @endif

                        @if(! empty($order->discount->subproduct_amount_from))
                            <dt>Действие начиная с количества товаров</dt>
                            <dd id="discount_amount">{{$order->discount->subproduct_amount_from}}</dd>
                        @endif

                    </dl>
                    <form id="updateOrderDiscountForm" action="#">
                        <input class="hidden" id="orderDiscountId"
                               value="{{$order->discount->id}}">

                        <div class="form-group">
                            status:
                            <input id="status" type="text" class="form-control" name="status"
                                   value="{{$order->discount->status}}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Обновить Discount
                            </button>
                        </div>
                    </form>
                </div>
            @endif
            <div id="updateOrderBonuses">
                <form id="updateOrderBonusesForm" action="#">
                    <h2>Обновить бонусы</h2>
                    <input class="hidden" id="orderBonusesId"
                           value="{{$order->bonuses->id or null}}">
                    <div class="form-group">
                        Количество бонусов:
                        <input id="bonus_count" type="number" step="1" min="0" class="form-control" name="bonus_count"
                               value="{{$order->bonuses->bonus_count or 0}}">
                    </div>
                    <span class="help-block" id="bonusError">

                    </span>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Обновить бонусы
                        </button>
                    </div>
                </form>
            </div>


            <div id="updateOrderBalance">
                <form id="updateOrderBalanceForm" action="#">
                    <h2>Обновить сумму из персонального счета</h2>
                    <input class="hidden" id="orderBalanceId"
                           value="@if(!isset($order)) {{$order->balance->id}} @endif">
                    <div class="form-group">
                        Сумма снятая с персонального счета:
                        <input id="balance_count" type="number" step="1" min="0" class="form-control"
                               name="balance_count"
                               value="{{$order->balance->balance_count or 0}}">
                    </div>
                    <span class="help-block" id="balanceError">

                    </span>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Обновить сумму персонального счета
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="orderLogs">
        @include('admin.panel.orders.orderLogs');
    </div>

    </div>
    <script>

        {{-- START Section ajax paginate logs --}}

          $(window).on('hashchange', function () {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getOrderLogs(page);
                }
            }
        });
        $(document).ready(function () {
            $(document).on('click', '.pagination a', function (e) {
                getOrderLogs($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });
        });
        function getOrderLogs(page) {
            $.ajax({
                url: '?page=' + page,
                dataType: 'json'
            }).done(function (data) {
                $('.orderLogs').html(data);
                location.hash = page;
            }).fail(function () {
                alert('OrderLogs could not be loaded.');
            });
        }

        {{-- END Section ajax paginate logs --}}

        $("#updateOrderStatusForm").submit(function (e) {
            e.preventDefault();
            console.log('submit updateOrderStatusForm clicked');
            var id = $("#orderStatusId").val();
            var status = $("#order_status").val();
            $.ajax({
                method: "PUT",
                url: "{{route('adminPanel.orderStatus.update', ['user' => $userId, 'order' => $orderId])}}",
                data: {
                    id: id,
                    admin_status: status
                },
                success: function (orderStatus) {
                    $("#deliveryId").val(orderStatus.id);
                    $("#order_status").val(orderStatus.admin_status);

                    var orderId = $('#public_order_id').val();
                    $.each(orderStatus.order_logs, function (i, v) {
                        $('#orderLogTbody').prepend(
                                "<tr><td>" + v.date +
                                "</td><td>" + v.log_action.name + ' поле ' + v.field_changed + ' ' + v.loggable_type + ' заказа № '
                                + orderId +
                                ' с ' + v.fromto.from + ' на ' + v.fromto.to + '. Автор - ' + v.author.name +
                                "</td></tr>"
                        );
                    });

                    console.log(orderStatus);

                },
                error: function () {
                    console.log(error);
                }
            });
        });

        $("#updateOrderForm").submit(function (e) {
            e.preventDefault();
            console.log('submit OrderIndex clicked');
            var id = $("#orderId").val();
            var public_order_id = $("#public_order_id").val();
            var total_sum = $("#total_sum").val();
            var total_quantity = $("#total_quantity").val();
            var comment = $("#comment").val();

            console.log(name);
            $.ajax({
                method: "PUT",
                url: "{{route('adminPanel.orderIndex.update', ['user' => $userId, 'order' => $orderId])}}",
                data: {
                    id: id,
                    public_order_id: public_order_id,
                    total_sum: total_sum,
                    total_quantity: total_quantity,
                    comment: comment
                },
                success: function (order) {

                    $("#orderId").val(order.id);
                    $("#public_order_id").val(order.public_order_id);
                    $("#total_sum").val(order.total_sum);
                    $("#total_quantity").val(order.total_quantity);
                    $("#comment").val(order.comment);

                    var orderId = $('#public_order_id').val();
                    $.each(order.order_logs, function (i, v) {
                        $('#orderLogTbody').prepend(
                                "<tr><td>" + v.date +
                                "</td><td>" + v.log_action.name + ' поле ' + v.field_changed + ' ' + v.loggable_type + ' заказа № '
                                + orderId +
                                ' с ' + v.fromto.from + ' на ' + v.fromto.to + '. Автор - ' + v.author.name +
                                "</td></tr>"
                        );
                    });
                    console.log(order);
                },
                error: function () {
                    console.log(error);
                }
            });
        });

        $("#updateOrderDeliveryForm").submit(function (e) {
            e.preventDefault();
            console.log('submit updateOrderDeliveryForm clicked');
            var id = $("#deliveryId").val();

            var delivery_type_id = $("#delivery_type_id").val();
            var delivery_f_name = $("#delivery_f_name").val();
            var delivery_l_name = $("#delivery_l_name").val();
            var delivery_phone = $("#delivery_phone").val();
            var delivery_address = $("#delivery_address").val();
            console.log(id);
            $.ajax({
                method: "PUT",
                url: "{{route('adminPanel.orderDelivery.update', ['user' => $userId, 'order' => $orderId])}}",
                data: {
                    id: id,
                    delivery_type_id: delivery_type_id,
                    delivery_f_name: delivery_f_name,
                    delivery_l_name: delivery_l_name,
                    delivery_phone: delivery_phone,
                    delivery_address: delivery_address
                },
                success: function (orderDelivery) {
                    console.log(orderDelivery);

                    $("#deliveryId").val(orderDelivery.id);
                    $("#delivery_type_id").val(orderDelivery.delivery_type_id);
                    $("#delivery_f_name").val(orderDelivery.delivery_f_name);
                    $("#delivery_l_name").val(orderDelivery.delivery_l_name);
                    $("#delivery_phone").val(orderDelivery.delivery_phone);
                    $("#delivery_address").val(orderDelivery.delivery_address);

                    var orderId = $('#public_order_id').val();
                    $.each(orderDelivery.order_logs, function (i, v) {
                        $('#orderLogTbody').prepend(
                                "<tr><td>" + v.date +
                                "</td><td>" + v.log_action.name + ' поле ' + v.field_changed + ' ' + v.loggable_type + ' заказа № '
                                + orderId +
                                ' с ' + v.fromto.from + ' на ' + v.fromto.to + '. Автор - ' + v.author.name +
                                "</td></tr>"
                        );
                    });

                },
                error: function () {
                    console.log(error);
                }
            });
        });

        $("#updateOrderContactDetailsForm").submit(function (e) {
            e.preventDefault();
            console.log('submit updateOrderContactDetailsForm clicked');
            var id = $("#contactDetailsId").val();
            var f_name = $("#f_name").val();
            var l_name = $("#l_name").val();
            var city = $("#city").val();
            var cell = $("#cell").val();
            var email = $("#email").val();

            $.ajax({
                method: "PUT",
                url: "{{route('adminPanel.orderContactDetails.update', ['user' => $userId, 'order' => $orderId])}}",
                data: {
                    id: id,
                    f_name: f_name,
                    l_name: l_name,
                    city: city,
                    cell: cell,
                    email: email
                },
                success: function (orderContactDetails) {
                    console.log(orderContactDetails);

                    $("#contactDetailsId").val(orderContactDetails.id);
                    $("#f_name").val(orderContactDetails.f_name);
                    $("#l_name").val(orderContactDetails.l_name);
                    $("#city").val(orderContactDetails.city);
                    $("#cell").val(orderContactDetails.cell);
                    $("#email").val(orderContactDetails.email);

                    var orderId = $('#public_order_id').val();
                    $.each(orderContactDetails.order_logs, function (i, v) {
                        $('#orderLogTbody').prepend(
                                "<tr><td>" + v.date +
                                "</td><td>" + v.log_action.name + ' поле ' + v.field_changed + ' ' + v.loggable_type + ' заказа № '
                                + orderId +
                                ' с ' + v.fromto.from + ' на ' + v.fromto.to + '. Автор - ' + v.author.name +
                                "</td></tr>"
                        );
                    });
                },
                error: function () {
                    console.log(error);
                }
            });
        });

        $("#updateOrderPaymentForm").submit(function (e) {
            e.preventDefault();
            console.log('submit updateOrderPaymentForm clicked');
            var payment_type = $("#payment_type").val();

            $.ajax({
                method: "PUT",
                url: "{{route('adminPanel.orderPayment.update', ['user' => $userId, 'order' => $orderId])}}",
                data: {
                    payment_type: payment_type
                },
                success: function (paymentType) {
                    $("#payment_type").val(paymentType.id);

                    var orderId = $('#public_order_id').val();
                    $.each(paymentType.order_logs, function (i, v) {
                        $('#orderLogTbody').prepend(
                                "<tr><td>" + v.date +
                                "</td><td>" + v.log_action.name + ' поле ' + v.field_changed + ' ' + v.loggable_type + ' заказа № '
                                + orderId +
                                ' с ' + v.fromto.from + ' на ' + v.fromto.to + '. Автор - ' + v.author.name +
                                "</td></tr>"
                        );
                    });
                    console.log(paymentType);

                },
                error: function () {
                    console.log(error);
                }
            });
        });

        $("#updateOrderDiscountForm").submit(function (e) {
            e.preventDefault();
            console.log('submit updateOrderDiscountForm clicked');
            var id = $("#orderDiscountId").val();
            var discount_amount = $("#discount_amount").text();

            var active_from = $("#active_from").text();
            var active_to = $("#active_to").text();
            var status = $("#status").val();

            console.log(discount_amount + '  ' + active_from + "  " + status);
            $.ajax({
                method: "PUT",
                url: "{{route('adminPanel.orderDiscount.update', ['user' => $userId, 'order' => $orderId])}}",
                data: {
                    id: id,
                    discount_amount: discount_amount,
                    active_from: active_from,
                    active_to: active_to,
                    status: status
                },
                success: function (orderDiscount) {
                    $("#orderDiscountId").val(orderDiscount.id);
                    $("#discount_amount").text(orderDiscount.discount_amount);
                    $("#active_from").text(orderDiscount.active_from);
                    $("#active_to").text(orderDiscount.active_to);
                    $("#status").val(orderDiscount.status);


                    console.log(orderDiscount);

                },
                error: function () {
                    console.log(error);
                }
            });
        });

        $("#updateOrderBonusesForm").submit(function (e) {
            e.preventDefault();
            console.log('submit updateOrderBonusesForm clicked');
            var id = $("#orderBonusesId").val();
            var bonus_count = $("#bonus_count").val();

            $.ajax({
                method: "PUT",
                url: "{{route('adminPanel.orderBonuses.update', ['user' => $userId, 'order' => $orderId])}}",
                data: {
                    id: id,
                    bonus_count: bonus_count
                },
                success: function (orderBonuses) {
                    $("#orderBonusesId").val(orderBonuses.id);
                    $("#bonus_count").text(orderBonuses.bonus_count);

                    var orderId = $('#public_order_id').val();
                    $.each(orderBonuses.order_logs, function (i, v) {
                        $('#orderLogTbody').prepend(
                                "<tr><td>" + v.date +
                                "</td><td>" + v.log_action.name + ' поле ' + v.field_changed + ' ' + v.loggable_type + ' заказа № '
                                + orderId +
                                ' с ' + v.fromto.from + ' на ' + v.fromto.to + '. Автор - ' + v.author.name +
                                "</td></tr>"
                        );
                    });

                    console.log(orderBonuses);
                },
                error: function (jqXHR, exception) {
                    if (jqXHR.status == 422) {
                        $('#bonusError').show();
                        $('#bonusError').append('<strong>' + jqXHR.responseText + '</strong>');
                    }
                }
            });
        });


        $("#updateOrderBalanceForm").submit(function (e) {
            e.preventDefault();
            console.log('submit updateOrderBalanceForm clicked');
            var balance_count = $("#balance_count").val();

            $.ajax({
                method: "PUT",
                url: "{{route('adminPanel.orderBalance.update', ['user' => $userId, 'order' => $orderId])}}",
                data: {
                    balance_count: balance_count
                },
                success: function (orderBalance) {
                    $("#balance_count").text(orderBalance.balance_count);

                    var orderId = $('#public_order_id').val();
                    $.each(orderBalance.order_logs, function (i, v) {
                        $('#orderLogTbody').prepend(
                                "<tr><td>" + v.date +
                                "</td><td>" + v.log_action.name + ' поле ' + v.field_changed + ' ' + v.loggable_type + ' заказа № '
                                + orderId +
                                ' с ' + v.fromto.from + ' на ' + v.fromto.to + '. Автор - ' + v.author.name +
                                "</td></tr>"
                        );
                    });

                    console.log(orderBalance);
                },
                error: function (jqXHR, exception) {
                    if (jqXHR.status == 422) {
                        $('#bonusError').show();
                        $('#bonusError').append('<strong>' + jqXHR.responseText + '</strong>');
                    }
                }
            });
        });
    </script>
    <style>
        #bonusError {
            display: none;
        }
    </style>
@stop