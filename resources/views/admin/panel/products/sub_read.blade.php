<div class="add_sub">

    <div class="row">

        <div class="col-md-4">
            <label for="subProductBarcode">Введите баркод</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" id="subProductBarcode" name="subProductBarcode_{{ $id }}" required />
        </div>

        <div class="col-md-4">
            <label for="subProductDelivery">Доставка ( в днях )</label>
        </div>
        <div class="col-md-8">
            <input type="number" class="form-control" id="subProductDelivery" name="subProductDelivery_{{ $id }}" required />
        </div>

        <div class="col-md-4">
            <label for="subProductQuantity">Введите количество</label>
        </div>
        <div class="col-md-8">
            <input type="number" class="form-control" id="subProductQuantity" name="subProductQuantity_{{ $id }}" required />
        </div>

        <div class="col-md-4">
            <label for="subProductSize">Введите размер предмета</label>
        </div>
        <div class="col-md-8">
            <select id="subProductSize" name="subProductSize_{{ $id }}" class="form-control" required>

                @foreach( $sizes as $size )

                    <option value="{{ $size->id }}">{{ $size->name }}</option>

                @endforeach

            </select>
        </div>

        <div class="col-md-4">
            <label for="subProductColor">Введите цвет предмета</label>
        </div>
        <div class="col-md-8">
            <select id="subProductColor" name="subProductColor_{{ $id }}" class="form-control" required>

                @foreach( $colors as $color )

                    <option value="{{ $color->id }}">{{ $color->name }}</option>

                @endforeach

            </select>
        </div>

        <div class="col-md-4">
            <label for="subProductAdditionalPrice">Введите наценку за предмет</label>
        </div>
        <div class="col-md-8">
            <input type="number" class="form-control" id="subProductAdditionalPrice" required name="subProductAdditionalPrice_{{ $id }}" />
        </div>

        <div class="col-md-4">
            <label for="subProductPhoto">Выберите фотографии</label>
        </div>
        <div class="col-md-8" id="photos_{{ $id }}">

        </div>

    </div>

</div>