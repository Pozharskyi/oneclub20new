@if( $alert !== false )

    @if( $alert == 'success' )

        <div class="alert alert-success">
            <strong>Успех!</strong> Вы успешно обновили информацию.
        </div>

    @elseif( $alert == 'created' )

        <div class="alert alert-success">
            <strong>Успех!</strong> Вы успешно добавили новую информацию.
        </div>

    @elseif( $alert == 'brand_exists' )

        <div class="alert alert-warning">
            <strong>Ошибка!</strong> Данный бренд уже существует.
        </div>

    @elseif( $alert == 'color_exists' )

        <div class="alert alert-warning">
            <strong>Ошибка!</strong> Данный цвет уже существует.
        </div>

    @elseif( $alert == 'size_exists' )

        <div class="alert alert-warning">
            <strong>Ошибка!</strong> Данный размер уже существует.
        </div>

    @else

        <div class="alert alert-danger">
            <strong>Ошибка!</strong> Попробуйте чуть позже выполнить данный запрос.
        </div>

    @endif

@endif