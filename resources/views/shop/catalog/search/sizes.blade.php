@foreach( $data as $type )

    <input type="radio" onclick="getProductQuantity( {{ $type->size->id }} )" name="size" id="size" value="{{ $type->size->id }}" required /> {{ $type->size->name }}

@endforeach