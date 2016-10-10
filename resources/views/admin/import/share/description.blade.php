@extends('layouts/adminPanel')

@section('title') Страница просмотра товарных акций @stop

@section('content')

    @if( !is_null( $message ) )
        @if( $message == 'true' )

            <div class="alert alert-success" style="margin-top: -22px;">
                <strong>Успех!</strong> Вы успешно добавили товарную акцию.
            </div>

        @endif
    @endif

    @include('admin.import.sub-nav')
    @include('admin.import.share.nav.sub-nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 25px;">
            <h2>Просмотр описания акции #{{ $share_id }}</h2>
        </div>

        <form action="{{ url('/admin/import/share/update') }}" method="post">

            {{ csrf_field() }}

            <div class="container">
                <div class="row">

                    <div class="col-md-4">
                        <label for="share_name" style="margin-top: 25px;">Название товарной акции</label>
                        <input type="text" class="form-control" name="share_name" id="share_name" value="{{ $share->sales_share_name }}" required />

                        <label for="recommended_start" style="margin-top: 25px;">Выберите дату начала</label>
                        <input type="text" class="form-control" placeholder="2016-09-10 10:10:10" value="{{ $share->sales_share_start }}" name="recommended_start" id="recommended_start" required />

                        <label for="recommended_end" style="margin-top: 25px;">Выберите дату конца</label>
                        <input type="text" class="form-control" placeholder="2016-09-20 10:10:10" value="{{ $share->sales_share_end }}" name="recommended_end" id="recommended_end" required />
                    </div>

                    <div class="col-md-4">

                        <label for="parties" style="margin-top: 25px;">Выберите товарные партии</label><br />

                        @foreach( $parties as $party )

                            <input type="checkbox" name="parties[]" id="parties" value="{{ $party->id }}"

                                @if( in_array( $party->id, $checked ) )
                                    checked
                                @elseif( in_array( $party->id, $nonActive ) )
                                    disabled
                                @endif

                            /> {{ $party->party_name }} ( Id: #{{ $party->id }} ) <br />

                        @endforeach

                    </div>
                </div>

                <input type="hidden" id="share_id" name="share_id" value="{{ $share_id }}" />

                <div class="text-center" style="margin-top: 30px; margin-bottom: 30px;">
                    <button class="btn btn-warning">Обновить товарную акцию</button>
                </div>

            </div>
        </form>

    </div>

@endsection