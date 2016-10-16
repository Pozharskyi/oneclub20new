<div class="row">

    <div class="text-center">
        <h3>Создание товарной акции</h3>
    </div>

    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="#" method="post" id="saleCreateForm">
            <label class="form_label" for="sale_name">Название товарной акции</label>
            <input type="text" name="sale_name" id="sale_name" class="form-control" />
            <p class="alert_message" id="invalid_sale_name"></p>

            <label class="form_label" for="buyer_id">Выберите ответственного баера</label>

            <!-- TODO -->
            <select id="buyer_id" name="buyer_id" class="form-control">
                <option value=""></option>
                <option value="1">Александр Сердюк</option>
            </select>
            <p class="alert_message" id="invalid_buyer_id"></p>

            <div class="row">
                <div class="col-md-6">
                    <label class="form_label" for="sale_start_date">Дата старта</label>
                    <input type="text" name="sale_start_date" id="sale_start_date" class="form-control" />
                    <p class="alert_message" id="invalid_sale_start_date"></p>
                </div>
                <div class="col-md-6">
                    <label class="form_label" for="sale_end_date">Дата окончания</label>
                    <input type="text" name="sale_end_date" id="sale_end_date" class="form-control" />
                    <p class="alert_message" id="invalid_sale_end_date"></p>
                </div>
            </div>

            <div class="text-center">
                <button type="button" id="go_back" onclick="closePopup();" class="btn btn-default">Отменить</button>
                <button type="button" onclick="createSale();" class="btn btn-primary btn_confirm">Создать товарную акцию</button>
            </div>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<script type="text/javascript" src="{{ url('/js/admin/import/sales/create.js') }}"></script>