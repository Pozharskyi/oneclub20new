@if( !is_null( $alert ) && isset( $alert ) )

    @if( $alert == 'confirmed' )
        <div class="alert alert-success">
            <strong>Успех!</strong> Товар был успешно подтвержден
        </div>
    @elseif( $alert == 'edited' )
        <div class="alert alert-danger">
            <strong>Успех!</strong> Товар был успешно откоректирован
        </div>
    @elseif( $alert == 'failed' )
        <div class="alert alert-danger">
            <strong>Ошибка!</strong> Попробуйте чуть позже.
        </div>
    @endif

@endif