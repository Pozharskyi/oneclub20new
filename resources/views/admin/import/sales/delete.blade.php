<div class="row">

    <div class="text-center">
        <h3>
            Подтвердите удаление товарной акции:
            {{ $sale->sale_name }} ( #{{ $sale->id }} )
        </h3>
    </div>

    <div class="col-md-4"></div>
    <div class="col-md-4">
        <form action="#" method="post" id="saleDeleteForm">
            <label class="comment comment_row" for="comment">Введите комментарий</label>
            <textarea class="form-control" rows="5" name="comment" id="comment"></textarea>
            <input type="hidden" name="import_index_sale_id" id="import_index_sale_id" value="{{ $sale->id }}" />

            <div class="text-center">
                <button type="button" id="go_back" onclick="closePopup();" class="btn btn-default">Отменить</button>
                <button type="button" onclick="deleteSale();" class="btn btn-primary btn_confirm">Подтвердить</button>
            </div>
        </form>
    </div>
    <div class="col-md-4"></div>

</div>

<script type="text/javascript" src="{{ url('/js/admin/import/sales/delete.js') }}"></script>