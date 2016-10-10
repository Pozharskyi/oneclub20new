@extends('layouts/adminPanel')

@section('title') Страница просмотра товарных партий @stop

@section('content')

    <div id="result_row"></div>

    @include('admin.import.sub-nav')
    @include('admin.import.parties.nav.nav')

    <div class="container">

        <div class="text-center" style="margin: 25px 0 25px 0;">
            <h2>Статистика по товарным партиям</h2>

            <p style="color: rgb(240, 0, 140);">Для того что бы получить информацию, выберите поставщика и его товарную партию</p>

        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <label for="supplier" style="margin-top: 15px;">Найдите нужного поставщика</label>
                <select onchange="getParties(this.value);" id="supplier" name="supplier" class="form-control">

                    <option>Выберите поставщика</option>

                    @foreach( $suppliers as $supplier )
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach

                </select>

                <label for="party" style="margin-top: 15px;">Найдите нужную товарную партию</label>
                <select onchange="getPartyDescription(this.value);" id="party" name="party" class="form-control">
                    <option>Выберите товарную партию</option>
                </select>
            </div>
            <div class="col-md-3"></div>
        </div>

        <div class="container" id="results"></div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/import/parties/stats.js') }}"></script>

@endsection