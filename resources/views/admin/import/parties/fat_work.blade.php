<div class="text-center" style="margin-bottom: 35px;">
    <h3>Отправить на доработку</h3>
</div>

<form action="#" method="post" id="workForm">
    <div class="container">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <label for="comment">Введите комментарий</label>
            <textarea id="comment" name="comment" class="form-control" rows="6" style="margin-bottom: 25px;"></textarea>

            <input type="checkbox" name="work_type[]" value="PHOTO" /> Отправить на фотосьемку <br />
            <input type="checkbox" name="work_type[]" value="CONTENT" /> Отправить контенщикам

            <input type="hidden" name="party_id" value="{{ $party_id }}" />
            <input type="hidden" name="file_line" id="file_line" value="{{ $file_line }}" />
            <input type="hidden" name="fat_status_id" value="{{ $fat_status_id }}" />
            <input type="hidden" name="type" value="work" />

            <div class="text-center" style="margin-top: 25px;">
                <button type="button" class="btn btn-primary" onclick="sendConfirmation();">Отправить на доработку</button>
            </div>

        </div>
        <div class="col-md-3"></div>
    </div>
</form>