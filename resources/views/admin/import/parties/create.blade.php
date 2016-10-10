@extends('layouts/adminPanel')

@section('title') Страница добавления товарных партий @stop

@section('content')

    @if( !is_null( $alert ) )

        @if( $alert == 'success' )
            <div class="alert alert-success" style="margin-top: -22px;">
                <strong>Успех!</strong> Товарная партия была добавлена
            </div>
        @elseif( $alert == 'failed' )
            <div class="alert alert-danger" style="margin-top: -22px;">
                <strong>Ошибка!</strong> Товарная партия не была добавлена
            </div>
        @endif

    @endif

    <div style="margin-top: 22px;"></div>

    @include('admin.import.sub-nav')
    @include('admin.import.parties.nav.nav')

    <form action="{{ url('/admin/import/parties/create') }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <label for="party_name" style="margin-top: 25px;">Название товарной партии</label>
                    <input type="text" class="form-control" name="party_name" id="party_name" required />

                    <label for="supplier" style="margin-top: 25px;">Выберите поставщика</label>
                    <select id="supplier" name="supplier" class="form-control" required>

                        <option></option>

                        @foreach( $suppliers as $supplier )
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach

                    </select>

                    <label for="recommended_start" style="margin-top: 25px;">Выберите рекомендованую дату начала</label>
                    <input type="text" class="form-control" placeholder="2016-09-10 10:10:10" name="recommended_start" id="recommended_start" required />

                    <label for="recommended_end" style="margin-top: 25px;">Выберите рекомендованую дату конца</label>
                    <input type="text" class="form-control" placeholder="2016-09-20 10:10:10" name="recommended_end" id="recommended_end" required />

                    <label for="party_category_id" style="margin-top: 25px;">Выберите категорию товарной партии</label><br />

                    @foreach( $parties_types as $parties_type )

                        <input type="radio" id="party_category_id" name="party_category_id" value="{{ $parties_type->id }}" required> {{ $parties_type->type }}

                    @endforeach

                    <br />

                    <label for="import" style="margin-top: 25px;">Выберите файл загрузки</label>
                    <input type="file" name="import" id="import" required />

                </div>
                <div class="col-md-4"></div>
            </div>

            <div class="text-center" style="margin-top: 30px; margin-bottom: 30px;">
                <button class="btn btn-warning">Создать товарную партию</button>
            </div>

        </div>
    </form>

@endsection