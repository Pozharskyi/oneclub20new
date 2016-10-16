@if( $count != 0 )

    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td># ТА</td>
                    <td>Ответственный баер</td>
                    <td>Название товарной акции</td>
                    <td>Дата старта</td>
                    <td>Дата окончания</td>
                </tr>
            </thead>
            <tbody>

            @foreach( $sales as $sale )
                <tr ondblclick="getSaleDescription({{ $sale->id }})" class="row_tr" id="row_{{ $sale->id }}"
                    onclick="makeSaleActive({{ $sale->id }});">
                    <td>
                        #{{ $sale->id }}
                    </td>
                    <td>
                        {{ $sale->buyer->name }}
                    </td>
                    <td>
                        {{ $sale->sale_name }}
                    </td>
                    <td>
                        {{ $sale->sale_start_date }}
                    </td>
                    <td>
                        {{ $sale->sale_end_date }}
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

@else

    <h3 class="alert_message">Результатов не найдено.</h3>

@endif