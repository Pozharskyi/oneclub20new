@extends('layouts.app')

@section('content')

    <script type="text/javascript" src="{{ url('/js/delivery/nova_poshta/main.js') }}"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>

            <div class="col-md-4">
                <form action="#" method="post">
                    <label for="city">Выберите город</label>
                    <select onchange="getDeliveryPoints( this.value )" name="city" id="city" class="form-control" required>

                        <option></option>

                        @foreach( $cities as $id => $city )
                            <option value="{{ $id }}">{{ $city }}</option>
                        @endforeach

                    </select>

                    <label for="delivery_point">Выберите место доставки</label>

                    <select name="delivery_point" id="delivery_point" class="form-control" required>

                    </select>

                    <button class="btn btn-primary">Выбрать</button>
                </form>
            </div>

            <div class="col-md-4"></div>
        </div>
    </div>
@endsection