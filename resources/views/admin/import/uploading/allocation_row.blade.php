<a id="closeDesc" onclick="hideDescriptionRow();">X</a>

<div class="row">
    <div class="row" style="padding: 15px;">

        <div class="col-md-12">

            <h3>Фотографии:</h3>

            @if($photos_count != 0)

                @php $i = 0 @endphp

                @foreach( $photos as $photo )

                    @if( $i == 0 || $i % 3 == 0 )
                        <div class="row">
                            @endif

                            <div class="col-md-4">
                                <img src="{{ $photo->photo_uri }}" class="image_row" />
                            </div>

                            @if( $i == 2 || $i % 3 == 2 )
                        </div>
                    @endif

                    @php $i++ @endphp

                @endforeach

            @else

                <h5 class="alert_message">Фотографий не найдено.</h5>

            @endif

            <h3>Контент</h3>

            @if( $data['material'] == '' && $data['description'] == '')
                <h5 class="alert_message">Описания не найдено.</h5>
            @else
                <h5>Материал: {{ $data['material'] }}</h5>
                <h5>Описание: {{ $data['description'] }}</h5>
            @endif

        </div>

        <div class="col-md-12">

            <h3>Основная информация</h3>

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

            <h3>Дополнительная информация</h3>

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
                    <h5>Коммент (админ часть): {{ $data['comment_admin'] }}</h5>
                    <h5>Коммент (лицевая часть): {{ $data['comment_frontend'] }}</h5>
                    <h5>Страна производитель: {{ $data['country_manufacturer'] }}</h5>
                </div>
            </div>

            @if( $logs == 0 )

                <h3>Задание</h3>

                <div class="row">

                    <form action="#" method="post" id="descForm">

                        <div class="col-md-12">
                            <input type="checkbox" name="tasks[]" value="2" /> Отправить на фотосьемку <br/>
                            <input type="checkbox" name="tasks[]" value="3" /> Отправить на контент <br/>
                        </div>

                        <div class="text-center">
                            <button type="button" onclick="confirmDescription();" style="margin-top: 15px;"
                                    class="btn btn-default">
                                Подтвердить
                            </button>
                        </div>

                        <input type="hidden" name="fileLine" id="fileLine" value="{{ $fileLine }}" />
                        <input type="hidden" name="categoryId" id="categoryId" value="{{ $categoryId }}" />

                    </form>

                </div>

            @else

                <h3>Задание уже было поставлено</h3>

            @endif
        </div>
    </div>
</div>