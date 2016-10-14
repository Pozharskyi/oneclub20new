@if( $count != 0 )

    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td># ТП</td>
                    <td>Ответственный баер</td>
                    <td>Поставщик</td>
                    <td>Название ТП</td>
                    <td>Дата старта</td>
                    <td>Дата окончания</td>
                    <td>Категория</td>
                    <td>Статус</td>
                </tr>
            </thead>
            <tbody>

                @foreach( $parties as $party )
                    <tr ondblclick="getPartyDescription({{ $party->id }});" class="row_tr

                    @if($party->import_parties_status_id == $deleted)
                        deleted
                    @endif

                    " id="row_{{ $party->id }}" onclick="makePartyActive({{ $party->id }});">
                        <td>
                            #{{ $party->id }}
                        </td>
                        <td>
                            {{ $party->buyer->name }}
                        </td>
                        <td>
                            {{ $party->supplier->name }}
                        </td>
                        <td>
                            {{ $party->party_name }}
                        </td>
                        <td>
                            {{ $party->party_start_date }}
                        </td>
                        <td>
                            {{ $party->party_end_date }}
                        </td>
                        <td>
                            {{ $party->importCategory->name }}
                        </td>
                        <td>
                            {{ $party->partiesStatus->parties_status }}
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

@else

    <h3 class="alert_message">Результатов не найдено.</h3>

@endif