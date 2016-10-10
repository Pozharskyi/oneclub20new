<div class="container">
    <div class="text-center">
        <h3>
            Редактирование продукта с barcode<br />
            <span style="color: rgb(240, 0, 140);">{{ $info->barcode }}</span>
        </h3>
    </div>

    <div class="row" style="margin-top: 25px;">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form action="{{ url('/admin/departments/photography/edit') }}" method="post" id="editForm" enctype="multipart/form-data">

                {{ csrf_field() }}

                @php $i = 0 @endphp

                @while($i < $max)

                    @if( $i == 0 || $i % 3 == 0 )
                        <div class="row" style="border-bottom: 1px solid #e4e4e4; margin-bottom: 25px; padding-bottom: 25px;">
                    @endif

                    <div class="col-md-4">
                        <div>
                            <h5>Фото:</h5>
                            <img id="img_{{ $i }}" src="{{ $info->photos[$i]->photo }}" style="width: 100%; margin-bottom: 20px;" />

                            <div>
                                <button type="button" class="btn btn-default" onclick="deleteImage({{ $i }})">Удалить</button>
                                <button type="button" class="btn btn-primary" onclick="uploadImage({{ $i }})">Изменить</button>
                            </div>
                        </div>
                        <input onchange="readURL(this);" type="file" name="file_{{ $i }}" id="file_{{ $i }}" style="display: none;" />

                        <input type="text" name="oldSrc_{{ $i }}" id="oldSrc_{{ $i }}" value="{{ $info->photos[$i]->photo }}" style="display: none;" />
                        <input type="text" name="src_{{ $i }}" id="src_{{ $i }}" value="" style="display: none;" />
                    </div>

                    @if( $i == 2 || $i % 3 == 2 )
                        </div>
                    @endif

                    @php $i++ @endphp

                @endwhile

                <br />
                <input type="radio" name="confirmType" value="{{ $fat_status }}" required /> Отправить на проверку баеру <br />
                <input type="radio" checked name="confirmType" value="confirm" required /> Подвердить товар

                <input type="hidden" name="subProductId" id="subProductId" value="{{ $info->id }}" />

                <div class="text-center">
                    <button class="btn btn-default">Обновить товар</button>
                </div>

            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>