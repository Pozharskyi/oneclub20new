@extends('layouts/adminPanel')

@section('title') Страница просмотра статистики товарной акции @stop

@section('content')

    @include('admin.import.sub-nav')
    @include('admin.import.share.nav.sub-nav')

    <div class="container">
        <div class="text-center">
            <h2>
                Статистика по товарной акции: <br/>
                <span style="color: rgb(240, 0, 140);">{{ $description->sales_share_name }}</span>
            </h2>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <h3>
                    Название товарной акции:
                    <span style="color: #f0ad4e">{{ $description->sales_share_name }}</span>
                </h3>
                <h4>
                    Дата начала акции:
                    <span style="color: #259d6d">{{ $description->sales_share_start }}</span>
                </h4>
                <h4>
                    Дата конца акции:
                    <span style="color: #259d6d">{{ $description->sales_share_end }}</span>
                </h4>
                <h4>
                    Главный h1 товарной акции:
                    <span style="color: #259d6d">{{ $description->first_header }}</span>
                </h4>
                <h4>
                    Вторичный h2 товарной акции:
                    <span style="color: #259d6d">{{ $description->second_header }}</span>
                </h4>
                <h4>
                    Сделано:
                    <span style="color: #259d6d">{{ $description->user->name }}</span>
                </h4>
            </div>
            <div class="col-md-5">
                <h3>
                    Статистика по товарам:
                </h3>
                <ul>
                    <li>
                        Всего загружено товаров:
                        <span style="color: #002a80;">{{ $total['total_products'] }} шт.</span>
                    </li>
                    <li>
                        Из них новых:
                        <span style="color: #002a80;">
                            {{ $total['total_products'] - $total['found_products'] }} шт.
                        </span>
                    </li>
                    <li>
                        Из них повторов:
                        <span style="color: #002a80;">{{ $total['found_products'] }} шт.</span>
                    </li>
                </ul>
                <h3>
                    Статистика по деньгам:
                </h3>
                <ul>
                    <li>
                        Сток в деньгах: {{ $total['total_price'] }} UAH
                    </li>
                    <li>
                        Средняя стоимость товара: {{ $total['average_price'] }} UAH
                    </li>
                    <li>
                        Общяя маржа: {{ $total['total_marga'] }} UAH
                    </li>
                    <li>
                        Средняя маржа: {{ $total['average_marga'] }} UAH
                    </li>
                    <li>
                        Средняя скидка ( в процентах ): {{ $total['average_sale'] }} UAH
                    </li>
                    <li>
                        Сумма всех заказанных предметов: {{ $total['total_order'] }} UAH
                    </li>
                    <li>
                        Сумма всех заплаченных предметов: {{ $total['total_order_paid'] }} UAH
                    </li>
                </ul>
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="divider"></div>

        <div class="row">

            <div class="text-center">
                <h2>Статистика по брендам</h2>
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-10">

                <div class="row">

                    @foreach( $brands as $brand => $stats )

                        <div class="col-md-6">
                            <h3>Бренд: <span style="color: #f0ad4e">{{ $brand }}</span></h3>
                            <h3>Статистика по товарам</h3>
                            <ul>
                                <li>Всего загружено товаров:
                                    <span style="color: #002a80;">{{ $stats['count'] }} шт.</span>
                                </li>
                                <li>Заказано предметов:
                                    <span style="color: #002a80;">{{ $stats['totalOrdered'] }} шт.</span>
                                </li>
                                <li>Куплено предметов предметов:
                                    <span style="color: #002a80;">{{ $stats['totalOrderedPaid'] }} шт.</span>
                                </li>
                            </ul>
                            <h3>Статистика по товарам</h3>
                            <ul>
                                <li>Заказано на сумму: {{ $stats['totalPrice'] }} UAH</li>
                                <li>Куплено на сумму: {{ $stats['totalPaid'] }} UAH</li>
                            </ul>
                        </div>

                    @endforeach

                </div>

            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="divider"></div>

        <div class="row">

            <div class="text-center">
                <h2>Статистика по товарным партиям</h2>
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-10">

                @foreach($info as $data => $desc)

                    <div class="row">
                        <div class="col-md-6">
                            <h3>Товарная партия:
                                <a target="_blank" href="{{ url('/admin/import/parties/desc/' . $desc['party_id']) }}">
                                    {{ $data }}
                                </a>
                            </h3>
                            <h3>Статистика по товарам:</h3>
                            <ul>
                                <li>
                                    Всего загружено товаров:
                                    <span style="color: #002a80;">{{ $desc['total_products']  }} шт.</span>
                                </li>
                                <li>
                                    Из них новых:
                                    <span style="color: #002a80;">
                                        {{ $desc['total_products'] - $desc['found_products'] }} шт.
                                    </span>
                                </li>
                                <li>
                                    Из них повторов:
                                    <span style="color: #002a80;">{{ $desc['found_products'] }} шт.</span>
                                </li>
                            </ul>
                            <h3>Статистика по деньгам:</h3>
                            <ul>
                                <li>
                                    Сток в деньгах: {{ $desc['total_price'] }} UAH
                                </li>
                                <li>
                                    Средняя стоимость товара: {{ $desc['average_price'] }} UAH
                                </li>
                                <li>
                                    Общяя маржа: {{ $desc['total_marga'] }} UAH
                                </li>
                                <li>
                                    Средняя маржа: {{ $desc['average_marga'] }} UAH
                                </li>
                                <li>
                                    Средняя скидка ( в процентах ) : {{ $desc['average_sale'] }}%
                                </li>
                            </ul>
                            <h3>Статистика по заказам:</h3>
                            <ul>
                                <li>
                                    Сумма всех заказанных предметов по партии: {{ $desc['total_order'] }} UAH
                                </li>
                                <li>
                                    Сумма всех заплаченных по партии: {{ $desc['total_order_paid'] }} UAH
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">

                            @foreach( $desc['brands'] as $brand )
                                <h3>Бренд: <span style="color: #f0ad4e">{{ $brand['brand'] }}</span></h3>
                                <h3>Статистика по товарам:</h3>
                                <ul>
                                    <li>
                                        Количество загруженных предметов:
                                        <span style="color: #002a80;">{{ $brand['count'] }} шт.</span>
                                    </li>
                                    <li>
                                        Заказано предметов из бренда:
                                        <span style="color: #002a80;">{{ $brand['totalOrdered'] }} шт.</span>
                                    </li>
                                    <li>
                                        Заплачено за предметы из бренда:
                                        <span style="color: #002a80;">{{ $brand['totalOrderedPaid'] }} шт.</span>
                                    </li>
                                </ul>
                                <h3>Статистика по деньгам:</h3>
                                <ul>
                                    <li>
                                        Заказано на сумму: {{ $brand['totalPrice'] }} UAH
                                    </li>
                                    <li>
                                        Заплачено на сумму: {{ $brand['totalPaid'] }} UAH
                                    </li>
                                </ul>

                                <div style="width: 100%; height: 1px; background-color: rgb(240, 0, 140); margin: 25px 0 25px 0;"></div>
                            @endforeach

                        </div>
                    </div>

                    <div class="divider"></div>

                @endforeach

            </div>
            <div class="col-md-1"></div>
        </div>
    </div>

@endsection