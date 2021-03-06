<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="{{ url('/css/jasny/jasny-bootstrap.min.css') }}">

<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="{{ url('/js/jasny/jasny-bootstrap.min.js') }}"></script>

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

            <label for="upload" id="upload_label">Выберите список для загрузки</label>
            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                <div class="form-control" data-trigger="fileinput">
                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                    <span class="fileinput-filename"></span>
                </div>
                <span class="input-group-addon btn btn-default btn-file">
                    <span class="fileinput-new">Выберите файл</span>
                    <span class="fileinput-exists">Изменить</span>
                    <input type="file" name="file" id="upload">
                </span>
                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Удалить</a>
            </div>

            <input type="hidden" name="party_id" id="party_id" value="{{ $party->id }}" />

            <div class="text-center" id="list">
                <button type="button" id="left_btn" onclick="closePopup();" class="btn btn-default">Отмена</button>
                <button type="button" id="right_btn" onclick="getConfirmView();" class="btn btn-primary">Загрузить список</button>
            </div>

            <div class="logs">

                <h4>История:</h4>

                @if( $count_logs != 0 )
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Пользователь</th>
                                <th>Дата</th>
                                <th>Файл</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach( $logs as $log )
                                <tr>
                                    <td>
                                        {{ $log->madeBy->name }}
                                    </td>
                                    <td>
                                        {{ $log->created_at }}
                                    </td>
                                    <td>
                                        <a target="_blank"
                                           href="{{ url('/admin/import/uploading/prepare/errors?allocationId=' . $log->id) }}">
                                            Получить
                                        </a>
                                    </td>
                                    <td>
                                        {{ $log->allocation_status }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else

                    <h5 class="alert_message">Ничего не найдено.</h5>

                @endif

            </div>

        </form>
    </div>
    <div class="col-md-3"></div>

</div>

<script type="text/javascript" src="{{ url('/js/admin/import/uploading/create.js') }}"></script>