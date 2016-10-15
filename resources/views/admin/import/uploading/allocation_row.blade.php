<a id="closeDesc" onclick="hideDescriptionRow();">X</a>

<div class="row">
    <div class="row">

        @if(isset($data['img1']))
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ $data['img1'] }}" class="image_row" />
                    </div>
                    <div class="col-md-4">
                        <img src="{{ $data['img2'] }}" class="image_row" />
                    </div>
                    <div class="col-md-4">
                        <img src="{{ $data['img3'] }}" class="image_row" />
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ $data['img4'] }}" class="image_row" />
                    </div>
                    <div class="col-md-4">
                        <img src="{{ $data['img5'] }}" class="image_row" />
                    </div>
                    <div class="col-md-4">
                        <img src="{{ $data['img6'] }}" class="image_row" />
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h5>Артикул: {{ $data['sku'] }}</h5>
                    <h5>Баркод: {{ $data['barcode'] }}</h5>
                    <h5>Имя продукта поставщика: {{ $data['supplier_product_name'] }}</h5>
                    <h5>Размер: {{ $data['size'] }}</h5>
                    <h5>Цвет: {{ $data['color'] }}</h5>
                </div>
                <div class="col-md-6">
                    <h5>Категория 1: {{ $data['cat1'] }}</h5>
                    <h5>Категория 2: {{ $data['cat2'] }}</h5>
                    <h5>Категория 3: {{ $data['cat3'] }}</h5>
                    <h5>Имя продукта: {{ $data['product_name'] }}</h5>
                    <h5>Бренд: {{ $data['brand'] }}</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5>Цена закупки: {{ $data['purchase_price'] }}</h5>
                    <h5>Баркод: {{ $data['provider_price'] }}</h5>
                    <h5>Имя продукта поставщика: {{ $data['final_price'] }}</h5>
                    <h5>Размер: {{ $data['special_price'] }}</h5>
                    <h5>Цвет: {{ $data['discount'] }}</h5>
                </div>
                <div class="col-md-6">
                    <h5>Количество: {{ $data['quantity'] }}</h5>
                    <h5>Гендер: {{ $data['gender'] }}</h5>
                    <h5>Материал: {{ $data['material'] }}</h5>
                    <h5>Имя продукта: {{ $data['description'] }}</h5>
                    <h5>Коммент (админ часть): {{ $data['comment_admin'] }}</h5>
                    <h5>Коммент (лицевая часть): {{ $data['comment_frontend'] }}</h5>
                    <h5>Страна производитель: {{ $data['country_manufacturer'] }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>