<table class="table table-striped" style="margin-top: 25px;">
    <thead>
    <tr>
        <th>Тип уведомления</th>
        <th>Id сообщение #</th>
        <th>Параметры</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @foreach( $list as $data )
        <tr>
            <td>
                <p>{{ $data->notification_type }}</p>
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Введите #id" id="message_id_{{ $data->id }}" value="{{ $data->notification_request_message }}" />
            </td>
            <td>
                <button onclick="getNotificationsParams('{{ $data->id }}');" class="btn btn-primary">
                    Выбрать...
                </button>
            </td>
            <td>
                <button type="button" onclick="saveEvent();" class="btn btn-default">
                    Сохранить
                </button>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>

<input type="hidden" id="event_id" value="{{ $event_id }}" />
<input type="hidden" id="sequence_id" value="" />
<input type="hidden" id="params" value="" />