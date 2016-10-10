@if( $count == 0 )

    <div class="text-center">
        <h2 style="color: rgb(240, 0, 140);">Результатов не найдено.</h2>
    </div>

@else

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id партии</th>
                <th>Категория</th>
                <th>Поставщик</th>
                <th>Рекомендованая дата старта</th>
                <th>Рекомендованая дата конца</th>
                <th>Сделано</th>
                <th>Дата создания</th>
                <th>Просмотр</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

            @foreach( $parties as $party )
                <tr>
                    <td>#{{ $party->id }}</td>
                    <td>{{ $party->partiesCategory->type }}</td>
                    <td>{{ $party->supplier->name }}</td>
                    <td>{{ $party->recommended_start }}</td>
                    <td>{{ $party->recommended_end }}</td>
                    <td>{{ $party->created_at }}</td>
                    <td>{{ $party->user->name }}</td>
                    <td>
                        <a href="{{ url( '/admin/import/parties/desc/' . $party->id ) }}">
                            <button class="btn btn-default">Просмотр</button>
                        </a>
                    </td>
                    <td>
                        <a href="javascript: void(0);" onclick="deleteParty({{ $party->id }});">X</a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

@endif