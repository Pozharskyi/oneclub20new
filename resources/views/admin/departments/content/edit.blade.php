<div class="container">
    <div class="text-center">
        <h3>
            Редактирование продукта с barcode<br />
            <span style="color: rgb(240, 0, 140);">{{ $info->barcode }}</span>
        </h3>
    </div>

    <div class="row" style="margin-top: 25px;">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form action="{{ url('#') }}" method="post" id="editForm">

                {{ csrf_field() }}

                <label for="product_name" style="margin-top: 15px;"></label>
                <textarea required class="form-control" rows="3" name="product_name" id="product_name">{{ $info->product->description->product_name }}</textarea>

                <label for="product_description" style="margin-top: 15px;"></label>
                <textarea required class="form-control" rows="3" name="product_description" id="product_description">{{ $info->product->description->product_description }}</textarea>

                <label for="product_composition" style="margin-top: 15px;"></label>
                <textarea required class="form-control" rows="3" name="product_composition" id="product_composition">{{ $info->product->description->product_composition }}</textarea>

                <label for="comment_frontend" style="margin-top: 15px;"></label>
                <textarea required class="form-control" rows="3" name="comment_frontend" id="comment_frontend">{{ $info->product->description->comment_frontend }}</textarea>

                <label for="country_manufacturer" style="margin-top: 15px;"></label>
                <textarea required class="form-control" rows="3" name="country_manufacturer" id="country_manufacturer">{{ $info->product->description->country_manufacturer }}</textarea>

                <br />
                <input type="radio" name="confirmType" value="{{ $fat_status }}" required /> Отправить на проверку баеру <br />
                <input type="radio" checked name="confirmType" value="confirm" required /> Подвердить товар

                <input type="hidden" name="subProductId" id="subProductId" value="{{ $info->id }}" />
                <input type="hidden" name="parentProductId" id="parentProductId" value="{{ $info->product->id }}" />

                <div class="text-center">
                    <button type="button" onclick="updateProduct();" class="btn btn-default">Обновить товар</button>
                </div>

            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>