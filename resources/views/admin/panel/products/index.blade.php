@extends('layouts.adminPanel')

@section('title') Admin - Products @stop

@section('content')

    <table class="table table-striped table-bordered">
        <caption class="text-center"><h2>Список продуктов</h2></caption>
        <thead>
        <tr>
            <td>Имя</td>
            <td>СКУ</td>
            <td>Описание</td>
            <td>Бренд</td>
            <td>Категория</td>
            <td>Изменить/Удалить</td>

        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->description->product_name }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->description->product_description }}</td>
                <td>{{ $product->brand->brand_name }}</td>
                <td>{{ $product->category->category_name }}</td>
                <td>
                    <div class="btn-group inline">

                        <a class="btn btn-small btn-info" href="{{ route('AdminPanel.product.edit', [$product->id])}}">Обновить
                            продукт</a>
                        <form action="{{route('AdminPanel.product.delete', [$product->id])}}" method="POST"
                              class="pull-right">
                            <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-small btn-danger">Удалить продукт</button>
                        </form>

                        <div data-id="{{$product->id}}" class="pull-right">
                            <button type="button" class="btn btn-small btn-info subProductList">Список субпродуктов
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="subProducts">

    </div>
    {{$products->links()}}


    <script>
        $('.subProductList').click(function (e) {
            var product_id = $(this).parent().data('id');
            console.log(product_id);
            $.ajax({
                url: "/admin/products/"+product_id+"/subproducts/list",
                dataType: 'json'
            }).done(function (data) {
                $('.subProducts').html(data);
            }).fail(function () {
                alert('subProducts could not be loaded.');
            });
        });
    </script>
@stop

