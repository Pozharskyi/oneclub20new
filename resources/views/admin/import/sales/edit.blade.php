<div class="row">

    <div class="text-center">
        <h3>
            Редактирование товарной акции<br />
            {{ $sale->sale_name }} ( #{{ $sale->id }} )
        </h3>
    </div>

    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="#" method="post" id="saleEditForm">
            <label class="form_label" for="sale_name">Название товарной акции</label>
            <input type="text" name="sale_name" id="sale_name" class="form-control" value="{{ $sale->sale_name }}" />
            <p class="alert_message" id="invalid_sale_name"></p>

            <label class="form_label" for="buyer_id">Ответственный баер</label>

            <!-- TODO -->
            <select id="buyer_id" name="buyer_id" class="form-control">
                <option value="1">Александр Сердюк</option>
            </select>
            <p class="alert_message" id="invalid_buyer_id"></p>

            <div class="row">
                <div class="col-md-6">
                    <label class="form_label" for="sale_start_date">Дата старта</label>
                    <input type="text" name="sale_start_date" value="{{ $sale->sale_start_date }}" id="sale_start_date" class="form-control" />

                    <p class="alert_message" id="invalid_sale_start_date"></p>
                </div>
                <div class="col-md-6">
                    <label class="form_label" for="sale_end_date">Дата окончания</label>
                    <input type="text" name="sale_end_date" value="{{ $sale->sale_end_date }}" id="sale_end_date" class="form-control" />

                    <p class="alert_message" id="invalid_sale_start_date"></p>
                </div>
            </div>

            <input type="hidden" name="sale_id" value="{{ $sale->id }}" />

            <div class="text-center">
                <button type="button" id="go_back" onclick="closePopup();" class="btn btn-default">Отменить</button>
                <button type="button" onclick="editSale();" class="btn btn-primary btn_confirm">Изменить товарную акцию</button>
            </div>

            <input type="hidden" name="old_sale_name" value="{{ $sale->party_name }}" />
            <input type="hidden" name="old_buyer_id" value="{{ $sale->buyer_id }}" />
            <input type="hidden" name="old_sale_start_date" value="{{ $sale->party_start_date }}" />
            <input type="hidden" name="old_sale_end_date" value="{{ $sale->party_end_date }}" />

            <input type="hidden" name="frontend_sale_name" value="Название товарной акции" />
            <input type="hidden" name="frontend_buyer_id" value="Баер" />
            <input type="hidden" name="frontend_sale_start_date" value="Дата старта" />
            <input type="hidden" name="frontend_sale_end_date" value="Дата окончания" />

        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<script type="text/javascript" src="{{ url('/js/admin/import/sales/edit.js') }}"></script>