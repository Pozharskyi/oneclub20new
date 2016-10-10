@if( $count == 0 )

    <h3 style="color: rgb(240, 0, 140);">Результатов не найдено</h3>

@else

    @foreach( $shares as $share )

        <tr id="share_{{ $share->id }}">
            <td>#{{ $share->id }}</td>
            <td>{{ $share->sales_share_name }}</td>
            <td>{{ $share->sales_share_start }}</td>
            <td>{{ $share->sales_share_end }}</td>
            <td>{{ $share->user->name }}</td>
            <td>
                <a href="{{ url( '/admin/import/share/desc/' . $share->id ) }}">
                    <button class="btn btn-default">Изменить</button>
                </a>
            </td>
            <td>
                <a href="javascript: void(0);" onclick="deleteShare({{ $share->id }});">X</a>
            </td>
        </tr>

    @endforeach

@endif