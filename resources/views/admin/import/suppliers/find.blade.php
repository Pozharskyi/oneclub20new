@if( $suppliers !== null )

    @foreach( $suppliers as $supplier )
        <tr id="result_{{ $supplier->id }}">
            <td>#{{ $supplier->id }}</td>
            <td>{{ $supplier->name }}</td>
            <th>{{ $supplier->shop }}</th>
            <th>{{ $supplier->phones }}</th>
            <th>{{ $supplier->coefficient }}</th>
            <th>{{ $supplier->product_marga }}</th>
            <th>{{ $supplier->agreement }}</th>
            <th>{{ $supplier->buyer->name }}</th>
            <td>{{ $supplier->user->name }}</td>
            <td>{{ $supplier->created_at }}</td>
            <td>
                <a onclick="deleteSupplier({{ $supplier->id }});" href="javascript: void(0);">X</a>
            </td>
        </tr>

        <tr>
            <td colspan="11">
                <a href="{{ url('/admin/import/suppliers/desc/' . $supplier->id) }}">
                    <button class="btn btn-default">Посмотреть</button>
                </a>
                <a href="{{ url('admin/import/suppliers/update/' . $supplier->id) }}">
                    <button class="btn btn-primary">Изменить</button>
                </a>
            </td>
        </tr>
    @endforeach

@else

    <h3 style="color: rgb(240, 0, 140);">Результатов не найдено</h3>

@endif