<div class="content">
    <h3>Выберите параметры для "{{ $sequence_name[0]->notification_type }}"</h3>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Выбрать</th>
                <th>Поле</th>
                <th>Его Template - значение</th>
            </tr>
        </thead>
        <tbody>

            @foreach( $sequences as $sequence_type )

                <tr>
                    <td>
                        <input type="checkbox" name="sequences" value="{{ $sequence_type->id }}"

                           @if( in_array( $sequence_type->id, $options ) )
                               checked
                           @endif

                        />
                    </td>
                    <td>
                        <p>{{ $sequence_type->name }}</p>
                    </td>
                    <td>
                        <p>{{ $sequence_type->template_name }}</p>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>
</div>

<div style="height: 300px;"></div>