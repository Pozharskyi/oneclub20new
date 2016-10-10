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

            <tr onclick="getDescription({{ $result['file_line'] }});"
                    @if( $result['fat_status_id'] == '9' )
                        style="background-color: #c1e2b3; cursor: pointer;"
                    @elseif( $result['fat_status_id'] == '11' )
                        style="background-color: #f1c40f; cursor: pointer;"
                    @elseif( $result['fat_status_id'] == '10' )
                        style="background-color: #d62728; cursor: pointer;"
                    @else
                        style="background-color: rgb(240, 0, 140); cursor: pointer;"
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
        @endforeach

        </tbody>
    </table>

@endif