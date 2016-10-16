<div id="alert_status">
    <div class="text-center">
        <h2 class="alert_message">{{ $message }}</h2>
        <button id="left_btn" type="button" onclick="goBackWithReload();" class="btn btn-default">Назад</button>
        <button id="right_btn" type="button" onclick="getPartyInfo();" class="btn btn-success">Перейти к обработке</button>
        <input type="hidden" id="success_party_id" name="success_party_id" value="{{ $party_id }}" />
    </div>
</div>

<script type="text/javascript" src="{{ url('/js/admin/import/uploading/csv_errors.js') }}"></script>