<div class="text-center" id="description">
    <h3>Описание ТП #{{ $party_id }}</h3>
</div>

@if( $count != 0 )

    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>sku</th>
                <th>barcode</th>
                <th>product_name</th>
                <th>brand</th>
                <th>color</th>
                <th>size</th>
            </tr>
        </thead>
        <tbody>

            @php $i = 1 @endphp

            @foreach( $rows as $row )
                <tr>
                    <td>
                        {{ $i }}
                    </td>
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

                @php $i++ @endphp
            @endforeach

        </tbody>
    </table>

    <div id="desc_nav">
        <button id="batchProcessor" class="btn btn-primary">Пакетная обработка</button>
        <button id="exportExcel" class="btn btn-default">Экспорт в Excel</button>
        <button id="sendToProd" class="btn btn-warning">Отправка в продакшн</button>
    </div>

    <input type="hidden" name="allocationId" id="allocationId" value="{{ $allocationId }}" />
    <script type="text/javascript" src="{{ url('/js/admin/import/uploading/description.js') }}"></script>

@else

    <h3 class="alert_message">Информации не найдено.</h3>

@endif