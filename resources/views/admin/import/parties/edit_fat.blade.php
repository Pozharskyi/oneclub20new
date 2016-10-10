<div class="container">

    @foreach( $errors as $error )
        <div class="alert alert-danger">
            {{ $error->message }}
        </div>
    @endforeach

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">

            <form action="#" method="post" id="editForm">

                @foreach( $results as $row => $value )

                    <label for="{{ $row }}">{{ $row }}</label>
                    <input type="text" class="form-control" name="{{ $row }}" id="{{ $row }}" value="{{ $value }}" />

                @endforeach

                <input type="hidden" name="party_id" id="party_id" value="{{ $party_id }}" />
                <input type="hidden" name="file_line" id="file_line" value="{{ $file_line }}" />
                <input type="hidden" name="fat_status_id" id="fat_status_id" value="{{ $fat_status_id }}" />

                <button type="button" onclick="confirmEditFile();" class="btn btn-default" style="margin: 25px 0 25px 0;">Обновить товар</button>
            </form>

        </div>
        <div class="col-md-3"></div>
    </div>
</div>