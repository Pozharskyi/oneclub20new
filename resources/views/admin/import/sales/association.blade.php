<div class="row">

    <div class="text-center">
        <h3>Привязка ТП к ТА</h3>
    </div>

    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form action="#" method="post" id="associationForm">

            <label class="form_label" for="ta-select">Выберите товарную акцию</label>
            <select data-placeholder="Выбрать..." id="ta-select" name="sale_id" class="ta-select">
                <option value="">&nbsp;</option>
                @foreach($sales as $sale)
                    <option value="{{ $sale->id }}">{{ $sale->sale_name }} ( #{{ $sale->id }} )</option>
                @endforeach
            </select>

            <label class="form_label" for="tp-select">Выберите товарную партию</label>
            <select data-placeholder="Выбрать..." id="tp-select" name="party_id" class="tp-select">
                <option value="">&nbsp;</option>
                @foreach($parties as $party)
                    <option value="{{ $party->id }}">{{ $party->party_name }} ( #{{ $party->id }} )</option>
                @endforeach
            </select>

        </form>
    </div>
    <div class="col-md-3"></div>
</div>

<div class="text-center manipulations_block">
    <button type="button" onclick="closePopup();" class="btn btn-default btn-man">Вернутся</button>
    <button type="button" onclick="cancelParty();" class="btn btn-default btn-man">Отменить</button>
    <button type="button" onclick="confirmParty();" class="btn btn-primary btn-man">Подтвердить</button>
</div>

<script type="text/javascript" src="{{ url('/js/admin/import/sales/association.js') }}"></script>