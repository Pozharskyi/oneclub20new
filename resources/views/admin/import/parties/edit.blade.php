<div class="row">

    <div class="text-center">
        <h3>
            Редактирование товарной партии<br />
            {{ $party->party_name }} ( #{{ $party->id }} )
        </h3>
    </div>

    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="#" method="post" id="partyEditForm">
            <label class="form_label" for="party_name">Название товарной партии</label>
            <input type="text" name="party_name" id="party_name" class="form-control" value="{{ $party->party_name }}" />
            <p class="alert_message" id="invalid_party_name"></p>

            <label class="form_label" for="import_supplier_id">Выберите поставщика</label>
            <select id="import_supplier_id" name="import_supplier_id" class="form-control">
                <option value=""></option>
                @foreach( $suppliers as $supplier )
                    <option value="{{ $supplier->id }}"

                    @if($supplier->id == $party->import_supplier_id)
                        selected
                    @endif

                    >{{ $supplier->name }}</option>
                @endforeach
            </select>
            <p class="alert_message" id="invalid_import_supplier_id"></p>

            <label class="form_label" for="buyer_id">Ответственный баера</label>

            <!-- TODO -->
            <select id="buyer_id" name="buyer_id" class="form-control">
                <option value="1">Александр Сердюк</option>
            </select>
            <p class="alert_message" id="invalid_buyer_id"></p>

            <label class="form_label" for="support_id">Ответственный контенщик</label>

            <!-- TODO -->
            <select id="support_id" name="support_id" class="form-control">
                <option value="2">Дмитрий Волков</option>
            </select>
            <p class="alert_message" id="invalid_support_id"></p>

            <div class="row">
                <div class="col-md-6">
                    <label class="form_label" for="party_start_date">Дата старта</label>
                    <input type="text" name="party_start_date" value="{{ $party->party_start_date }}" id="party_start_date" class="form-control" />

                    <p class="alert_message" id="invalid_party_start_date"></p>
                </div>
                <div class="col-md-6">
                    <label class="form_label" for="party_end_date">Дата окончания</label>
                    <input type="text" name="party_end_date" value="{{ $party->party_end_date }}" id="party_end_date" class="form-control" />

                    <p class="alert_message" id="invalid_party_end_date"></p>
                </div>
            </div>

            <label class="form_label" for="import_index_categories_id">Выберите категорию</label><br />

            @foreach( $categories as $category )
                <input type="radio" name="import_index_categories_id" id="import_index_categories_id" value="{{ $category->id }}"

                       @if($category->id == $party->import_index_categories_id)
                       checked
                       @endif

                />
                {{ $category->name }} <br />
            @endforeach

            <input type="hidden" name="party_id" value="{{ $party->id }}" />

            <div class="text-center">
                <button type="button" id="go_back" onclick="closePopup();" class="btn btn-default">Отменить</button>
                <button type="button" onclick="editParty();" class="btn btn-primary btn_confirm">Изменить товарную партию</button>
            </div>

            <input type="hidden" name="old_party_name" value="{{ $party->party_name }}" />
            <input type="hidden" name="old_import_supplier_id" value="{{ $party->import_supplier_id }}" />
            <input type="hidden" name="old_buyer_id" value="{{ $party->buyer_id }}" />
            <input type="hidden" name="old_support_id" value="{{ $party->support_id }}" />
            <input type="hidden" name="old_party_start_date" value="{{ $party->party_start_date }}" />
            <input type="hidden" name="old_party_end_date" value="{{ $party->party_end_date }}" />
            <input type="hidden" name="old_import_index_categories_id" value="{{ $party->import_index_categories_id }}" />

            <input type="hidden" name="frontend_party_name" value="Название товарной партии" />
            <input type="hidden" name="frontend_import_supplier_id" value="Поставщик" />
            <input type="hidden" name="frontend_buyer_id" value="Баер" />
            <input type="hidden" name="frontend_support_id" value="Контенщик" />
            <input type="hidden" name="frontend_party_start_date" value="Дата старта" />
            <input type="hidden" name="frontend_party_end_date" value="Дата окончания" />
            <input type="hidden" name="frontend_import_index_categories_id" value="Категория" />

        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<script type="text/javascript" src="{{ url('/js/admin/import/edit.js') }}"></script>