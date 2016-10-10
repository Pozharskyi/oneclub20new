@extends('layouts/adminPanel')

@section('title') Страница просмотра товарных партий @stop

@section('content')

    @if( !is_null( $message) )
        @if( $message = 'true' )
            <div class="alert alert-success" style="margin-top: -22px;">
                <strong>Успех!</strong> Вы успешно обновили товарную партию.
            </div>
        @elseif( $message = 'false' )
            <div class="alert alert-danger"  style="margin-top: -22px;">
                <strong>Ошибка!</strong> Вы не обновили товарную партию. Попробуйте чуть позже.
            </div>
        @endif
    @endif

    <div id="result_row"></div>

    @include('admin.import.sub-nav')
    @include('admin.import.parties.nav.nav')

    <form action="{{ url( '/admin/import/parties/edit/' . $party_id ) }}" method="post">

        {{ csrf_field() }}

        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <label for="party_name" style="margin-top: 15px;">Название товарной партии</label>
                    <input type="text" class="form-control" id="party_name" name="party_name" value="{{ $info->party_name }}" />

                    <label for="suppliers" style="margin-top: 15px;">Поставщик</label>
                    <select name="suppliers" id="suppliers" class="form-control">

                        @foreach( $suppliers as $supplier )
                            <option value="{{ $supplier->id }}"

                                    @if( $supplier->id == $info->supplier->id )
                                    selected
                                    @endif

                            >{{ $supplier->name }}</option>
                        @endforeach

                    </select>

                    <label for="recommended_start" style="margin-top: 15px;">Рекомендованый старт</label>
                    <input type="text" class="form-control" value="{{ $info->recommended_start }}" id="recommended_start" name="recommended_start" />

                    <label for="" style="margin-top: 15px;">Рекомендованый конец</label>
                    <input type="text" class="form-control" value="{{ $info->recommended_end }}" id="recommended_end" name="recommended_end" />

                    <label for="category" style="margin-top: 15px;">Категория</label>
                    <select name="category" id="category" class="form-control">

                        @foreach( $categories as $category )
                            <option value="{{ $category->id }}"

                                    @if( $category->id == $info->partiesCategory->id )
                                    selected
                                    @endif

                            >{{ $category->type }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-3"></div>
            </div>

            <div class="text-center" style="margin: 25px 0 25px 0;">
                <button class="btn btn-primary">Изменить товарную партию</button>
            </div>
        </div>
    </form>

@endsection