@extends('layouts.adminPanel')

@section('title') Discounts @stop

@section('breadcrumb')
    <li class="active">Добавить категории пользователей к дискаунту</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <form id="addUserCategories" method="POST" action="{{route('AdminPanel.discounts.addUserCategories', ['discount' => $discount->id ])}}">
                <h2>Добавить категории пользователей</h2>
                {{ csrf_field() }}

                <div class="form-group">
                    Категории пользователей:
                    <select id="userCategories" name="userCategories[]" multiple class="form-control">
                        @foreach($userCategories as $userCategory)
                            <option value="{{$userCategory->id}}">{{$userCategory->category}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Добавить категории пользователей
                    </button>
                </div>
            </form>
        </div>
    </div>

@stop