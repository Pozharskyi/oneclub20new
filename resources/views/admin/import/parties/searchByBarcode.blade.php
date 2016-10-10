@if( $count == 0 )

    <h2 style="color: rgb(240, 0, 140);">Результатов не найдено</h2>

@else

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Sku</th>
            <th>Barcode</th>
            <th>Цена</th>
            <th>Цена продажи</th>
            <th>Цвет</th>
            <th>Размер</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach( $products as $product )
            <tr id="product_{{ $product->id }}">
                <td>{{ $product->product->sku }}</td>
                <td>{{ $product->barcode }}</td>
                <td>{{ $product->price[0]->final_price }} грн.</td>
                <td>{{ $product->price[0]->special_price }} грн.</td>
                <td>{{ $product->color->name }}</td>
                <td>{{ $product->size->name }}</td>
                <td>
                    <a href="javascript: void(0);" onclick="deleteSubProduct({{ $product->id }});">X</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endif