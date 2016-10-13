<div class="row">

    <div class="text-center">
        <h3>
            Загрузка списка к товарной партии<br />
            {{ $party->party_name }} ( #{{ $party->id }} )
        </h3>
    </div>

    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form action="#" id="formContent" method="post" enctype="multipart/form-data" >
            <input type="file" name="file"  id="upload" required>
            <input type="hidden" name="party_id" id="party_id" value="{{ $party->id }}" />
            <button class="submitI" >Upload Image</button>
        </form>
    </div>
    <div class="col-md-3"></div>

</div>

<script type="text/javascript" src="{{ url('/js/admin/import/uploading/create.js') }}"></script>