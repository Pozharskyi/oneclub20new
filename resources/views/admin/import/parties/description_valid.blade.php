<div class="text-center" id="description">
    <h3>Описание ТП #{{ $party_id }}</h3>
</div>

@if( $count != 0 )

    <div class="row">
        <div class="col-md-12" id="primary_desc">
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

                @php $i = 0 @endphp

                @foreach( $rows as $row )
                    <tr id="validationRow_{{ $i }}" class="desc_row" onclick="getDescription({{ $i }});">
                        <td id="desc_{{ $i }}" style="background-color: {{ $row['validationColor'] }}">
                            <span style="color: rgb(240, 0, 140);">{{ $i + 1 }}</span>
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
        </div>

        <div id="desc"></div>
    </div>

    <div id="desc_nav">
        @if($availability != 'denied')
            <button id="batchProcessor" onclick="processWork();" class="btn btn-primary">Пакетная обработка</button>
        @endif

        <button id="exportExcel" class="btn btn-default">Экспорт в Excel</button>

        @if($availability != 'denied')
            <button id="sendToProd" class="btn btn-warning">Отправка в продакшн</button>
        @endif
    </div>

    <input type="hidden" name="allocationId" id="allocationId" value="{{ $allocationId }}" />
    <input type="hidden" name="filePath" id="filePath" value="{{ $filePath }}" />
    <input type="hidden" name="working_party_id" id="working_party_id" value="{{ $party_id }}" />
    <script type="text/javascript" src="{{ url('/js/admin/import/uploading/description.js') }}"></script>
    <div style="height: 250px"></div>

@else

    <h3 class="alert_message">Информации не найдено.</h3>

@endif