<div id="alert_status">
    <div class="text-center">
        <h2 class="alert_message">{{ $message }}</h2>
        <button id="left_btn" onclick="goBackWithReload();" class="btn btn-default">Назад</button>
        <button id="right_btn" onclick="getValidatedFile();" class="btn btn-primary">Получить файл</button>
        <input type="hidden" id="allocationId" name="allocationId" value="{{ $allocationId }}" />
    </div>
</div>

<script type="text/javascript" src="{{ url('/js/admin/import/uploading/csv_errors.js') }}"></script>