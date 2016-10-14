<div id="alert_status">
    <div class="text-center">
        <h2 class="alert_message">{{ $message }}</h2>
        <button onclick="getValidatedFile();" class="btn btn-success">Получить файл</button>
        <input type="hidden" id="allocationId" name="allocationId" value="{{ $allocationId }}" />
    </div>
</div>

<script type="text/javascript" src="{{ url('/js/admin/import/uploading/csv_errors.js') }}"></script>