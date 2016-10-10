@if( count( $notices ) == 0 )

    <h3 style="color: rgb(240, 0, 140);">Ничего не найдено</h3>

@else

    @foreach( $notices as $notice )

        @if( $notice->fat_status_id == 4)
            <div class="alert alert-danger">
                @elseif( $notice->fat_status_id == 5)
                    <div class="alert alert-warning">
                        @else
                            <div class="alert alert-success">
                                @endif

                                {{ $notice->message }}

                            </div>

            @endforeach

@endif