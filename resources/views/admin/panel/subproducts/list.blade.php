<table class="table table-striped table-bordered">
    <caption class="text-center"><h2>Список субпродуктов для продукта СКУ - {{$product->sku}}</h2></caption>
    <thead>
    <tr>
        <td>product_marga</td>
        <td>final_price</td>
        <td>barcode</td>
        <td>markup_price</td>
        <td>quantity</td>
        <td>delivery_days</td>
        <td>Изменить</td>

    </tr>
    </thead>
    <tbody>
    @foreach($subProducts as $subProduct)
        <tr>
            <td>{{$subProduct->price->product_marga}}</td>
            <td>{{ $subProduct->price->final_price }}</td>
            <td>{{ $subProduct->barcode }}</td>
            <td>{{ $subProduct->markup_price }}</td>
            <td>{{ $subProduct->quantity }}</td>
            <td>{{ $subProduct->delivery_days }}</td>
            <td>
                <div class="btn-group inline">

                    <a class="btn btn-small btn-info" href="{{ route('AdminPanel.subproduct.edit',
                    ['product'=>$product->id, 'subproduct'=>$subProduct->id])}}">Обновить
                        субпродукт</a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>