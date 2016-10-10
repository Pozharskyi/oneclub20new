@if( $count == 0 )

    <h3 style="color: rgb(240, 0, 140);">Результатов не найдено.</h3>

@else

    <table class="table" style="margin-top: 45px;" width="100%">
        <thead>
            <tr>
                <th>Имя продукта</th>
                <th>Категории</th>
                <th>Бренд</th>
                <th>Sku</th>
                <th>Barcode</th>
                <th>Цвет</th>
                <th>Размер</th>
                <th>Результат</th>
                <th>Фотографии</th>
            </tr>
        </thead>
        <tbody>

            @foreach( $results as $result )

                <tr
                    @if( $result['fat_status_id'] == '1' )
                        style="background-color: #c1e2b3; cursor: pointer;"
                    @elseif( $result['fat_status_id'] == '2' )
                        style="background-color: #f1c40f; cursor: pointer;"
                    @elseif( $result['fat_status_id'] == '3' )
                        style="background-color: #f0ad4e; cursor: pointer;"
                    @elseif( $result['fat_status_id'] == '4' )
                        style="background-color: #d62728; cursor: pointer;"
                    @else
                        style="background-color: #c1e2b3; cursor: pointer;"
                    @endif
                 class="fat_{{ $result['file_line'] }}">
                    <td>{{ $result['product_name'] }}</td>
                    <td>{{ $result['cat1'] }} / {{ $result['cat2'] }} / {{ $result['cat3'] }}</td>
                    <td>{{ $result['brand'] }}</td>
                    <td>{{ $result['sku'] }}</td>
                    <td>{{ $result['barcode'] }}</td>
                    <td>{{ $result['color'] }}</td>
                    <td>{{ $result['size'] }}</td>
                    <td>{{ $result['fat'] }}</td>
                    <td>
                        <a target="_blank" href="{{ $result['img1'] }}">Фото 1</a>
                        <a target="_blank" href="{{ $result['img2'] }}">Фото 2</a>
                        <a target="_blank" href="{{ $result['img3'] }}">Фото 3</a>
                        <a target="_blank" href="{{ $result['img4'] }}">Фото 4</a>
                        <a target="_blank" href="{{ $result['img5'] }}">Фото 5</a>
                        <a target="_blank" href="{{ $result['img6'] }}">Фото 6</a>
                    </td>
                </tr>
                <tr
                    @if( $result['fat_status_id'] == '1' )
                        style="background-color: #c1e2b3; cursor: pointer;"
                    @elseif( $result['fat_status_id'] == '2' )
                        style="background-color: #f1c40f; cursor: pointer;"
                    @elseif( $result['fat_status_id'] == '3' )
                        style="background-color: #f0ad4e; cursor: pointer;"
                    @elseif( $result['fat_status_id'] == '4' )
                        style="background-color: #d62728; cursor: pointer;"
                    @else
                        style="background-color: #c1e2b3; cursor: pointer;"
                    @endif
                 class="fat_{{ $result['file_line'] }}">
                    <td width="100%" colspan="9">
                    @if( $result['fat_status_id'] == '1' || $result['fat_status_id'] == 2 )
                        <button type="button" onclick="sendForWork({{ $result['file_line'] . ',' . $result['fat_status_id'] }});" class="btn btn-default">Доработка</button>
                        <button type="button" onclick="confirmProduct({{ $result['file_line'] . ',' . $result['fat_status_id'] }});" class="btn btn-primary">Оставить текущее</button>

                            @if( $result['uri'] != '' )
                                <button type="button" onclick="editWithAnother({{ $result['file_line'] . ',' . $result['fat_status_id'] }});" class="btn btn-danger">Перезаписать</button>
                                <a target="_blank" href="{{ $result['uri'] }}">
                                    <button type="button" class="btn btn-info">Совпадения</button>
                                </a>
                            @endif

                        <input type="hidden" id="sku_{{ $result['file_line'] }}" value="{{ $result['sku'] }}" />
                        <input type="hidden" id="barcode_{{ $result['file_line'] }}" value="{{ $result['barcode'] }}" />
                        <input type="hidden" id="color_{{ $result['file_line'] }}" value="{{ $result['color'] }}" />

                    @elseif( $result['fat_status_id'] == '3' )
                        <button type="button" onclick="sendForWork({{ $result['file_line'] . ',' . $result['fat_status_id'] }});" class="btn btn-default">Доработка</button>
                        <button type="button" onclick="confirmProduct({{ $result['file_line'] . ',' . $result['fat_status_id'] }});" class="btn btn-primary">Подтвердить</button>

                        @if( $result['uri'] != '' )
                            <a target="_blank" href="{{ $result['uri'] }}">
                                <button type="button" class="btn btn-info">Показать товар</button>
                            </a>
                        @endif

                    @elseif( $result['fat_status_id'] == '4' )
                        <button type="button" onclick="editImport({{ $result['file_line'] . ',' . $result['fat_status_id'] }});" class="btn btn-default">Исправить</button>

                        @if( $result['uri'] != '' )
                            <a target="_blank" href="{{ $result['uri'] }}">
                                <button type="button" class="btn btn-info">Показать совпадения</button>
                            </a>
                        @endif

                    @endif

                    <button type="button" onclick="getFileDescription({{ $result['file_line'] }});" class="btn btn-success">Уведомления</button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

@endif