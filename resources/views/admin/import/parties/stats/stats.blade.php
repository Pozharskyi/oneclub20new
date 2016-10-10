<div class="row" style="margin-top: 15px;">

    <div class="text-center">
        <a style="font-size: 18px;" target="_blank" href="{{ url('/admin/import/parties/export/' . $party_id) }}">Экспортировать для поставщика</a>
    </div>

    @foreach( $results as $category => $collection )
        <h2>Статистика за: {{ $category }}</h2>

        @if( count($collection ) == 0 )
            <h3 style="color: rgb(240, 0, 140);">Данных не найдено.</h3>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Номер заказа</th>
                    <th>Sku</th>
                    <th>Barcode</th>
                    <th>Цвет</th>
                    <th>Количество</th>
                    <th>Цена за единицу</th>
                    <th>Сумма</th>
                    <th>Дата добавления</th>
                </tr>
                </thead>
                <tbody>

                @php $totalQty = 0 @endphp
                @php $totalSum = 0 @endphp
                @php $avgSum = 0 @endphp
                @php $count = count( $collection ) @endphp

                @foreach( $collection as $info )
                    <tr>
                        <td>{{ $info->subProduct->product->product_store_id }}</td>
                        <td>{{ $info->subProduct->product->sku }}</td>
                        <td>{{ $info->subProduct->barcode }}</td>
                        <td>{{ $info->subProduct->color->name }}</td>
                        <td>{{ $info->qty }} шт.</td>
                        <td>{{ $info->price_for_one_product }} UAH</td>
                        <td>{{ $info->price_for_one_product * $info->qty }} UAH</td>
                        <td>{{ $info->updated_at }}</td>
                    </tr>

                    @php $totalQty += $info->qty @endphp
                    @php $totalSum += $info->price_for_one_product * $info->qty @endphp
                    @php $avgSum += $info->price_for_one_product @endphp

                @endforeach

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Среднее</td>
                    <td>{{ round( $totalQty / $count, 2) }} шт.</td>
                    <td>{{ round( $avgSum / $count, 2) }} UAH</td>
                    <td>{{ round( $totalSum / $count, 2) }} UAH</td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Сумма</td>
                    <td>{{ $totalQty }} шт.</td>
                    <td>{{ $avgSum }} UAH</td>
                    <td>{{ $totalSum }} UAH</td>
                    <td></td>
                </tr>

                </tbody>
            </table>
        @endif

        <div style="width: 50%; margin: 25px auto 25px auto; height: 1px; background-color: chocolate"></div>

    @endforeach

</div>