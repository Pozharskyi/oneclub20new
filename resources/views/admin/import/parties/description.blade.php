<div class="text-center" id="description">
    <h3>Описание ТП #{{ $party_id }}</h3>
</div>

@if( $count != 0 )

    <table class="table">
        <thead>
            <tr>
                <th>sku</th>
                <th>barcode</th>
                <th>product_name</th>
                <th>brand</th>
                <th>color</th>
                <th>size</th>
            </tr>
        </thead>
        <tbody>

            @foreach( $rows as $row )
                <tr>
                    <td>
                        {{ $row['sku'] }}
                    </td>
                    <td>
                        {{ $row['barcode'] }}
                    </td>
                    <td>
                        {{ $row['product_name'] }}
                    </td>
                    <td>
                        {{ $row['brand'] }}
                    </td>
                    <td>
                        {{ $row['color'] }}
                    </td>
                    <td>
                        {{ $row['size'] }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

@else

    <h3 class="alert_message">Информации не найдено.</h3>

@endif