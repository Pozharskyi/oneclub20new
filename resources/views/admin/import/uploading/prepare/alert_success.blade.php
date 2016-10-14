<div id="alert_status">
    <div class="text-center">
        <h2 class="alert_message">{{ $message }}</h2>
        <button onclick="getPartyInfo();" class="btn btn-success">Перейти к обработке</button>
        <input type="hidden" id="allocationId" name="allocationId" value="{{ $allocationId }}" />
    </div>
</div>