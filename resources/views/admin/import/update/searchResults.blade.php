@if( $count == 0 )

    <div class="text-center">
        <h2 style="color: rgb(240, 0, 140);">Результатов не найдено.</h2>
    </div>

@else

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id обновления</th>
                <th>Название</th>
                <th>Рекомендованая дата старта</th>
                <th>Сделано</th>
                <th>Дата создания</th>
                <th>Просмотр</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

            @foreach( $updates as $update )
                <tr>
                    <td>#{{ $update->id }}</td>
                    <td>{{ $update->update_name }}</td>
                    <td>{{ $update->recommended_start }}</td>
                    <td>{{ $update->user->name }}</td>
                    <td>{{ $update->created_at }}</td>
                    <td>
                        <a href="{{ url( '/admin/import/update/desc/' . $update->id ) }}">
                            <button class="btn btn-default">Просмотр</button>
                        </a>
                    </td>
                    <td>
                        <a href="javascript: void(0);" onclick="deleteUpdate({{ $update->id }});">X</a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

@endif