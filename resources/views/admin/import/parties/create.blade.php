<div class="row">

    <div class="text-center">
        <h3>Создание товарной партии</h3>
    </div>

    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="#" method="post" id="partyCreateForm">
            <label class="form_label" for="party_name">Название товарной партии</label>
            <input type="text" name="party_name" id="party_name" class="form-control" />
            <p class="alert_message" id="invalid_party_name"></p>

            <label class="form_label" for="import_supplier_id">Выберите поставщика</label>
            <select id="import_supplier_id" name="import_supplier_id" class="form-control">
                <option value=""></option>
                @foreach( $suppliers as $supplier )
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
            <p class="alert_message" id="invalid_import_supplier_id"></p>

            <label class="form_label" for="buyer_id">Выберите ответственного баера</label>

            <!-- TODO -->
            <select id="buyer_id" name="buyer_id" class="form-control">
                <option value=""></option>
                <option value="1">Александр Сердюк</option>
            </select>
            <p class="alert_message" id="invalid_buyer_id"></p>

            <label class="form_label" for="support_id">Выберите ответственного контенщика</label>

            <!-- TODO -->
            <select id="support_id" name="support_id" class="form-control">
                <option value=""></option>
                <option value="2">Дмитрий Волков</option>
            </select>
            <p class="alert_message" id="invalid_support_id"></p>

            <div class="row">
                <div class="col-md-6">
                    <label class="form_label" for="party_start_date">Дата старта</label>
                    <input type="text" name="party_start_date" id="party_start_date" class="form-control" />
                    <p class="alert_message" id="invalid_party_start_date"></p>
                </div>
                <div class="col-md-6">
                    <label class="form_label" for="party_end_date">Дата окончания</label>
                    <input type="text" name="party_end_date" id="party_end_date" class="form-control" />
                    <p class="alert_message" id="invalid_party_end_date"></p>
                </div>
            </div>

            <label class="form_label" for="import_index_categories_id">Выберите категорию</label><br />

            @foreach( $categories as $category )
                <input type="radio" name="import_index_categories_id" id="import_index_categories_id" value="{{ $category->id }}"

                       @if($category->id == 1)
                       checked
                        @endif

                />
                {{ $category->name }} <br />
            @endforeach

            <div class="text-center">
                <button type="button" id="go_back" onclick="closePopup();" class="btn btn-default">Отменить</button>
                <button type="button" onclick="createParty();" class="btn btn-primary btn_confirm">Создать товарную партию</button>
            </div>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<script type="text/javascript" src="{{ url('/js/admin/import/parties/create.js') }}"></script>