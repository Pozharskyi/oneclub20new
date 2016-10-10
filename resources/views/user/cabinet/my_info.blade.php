@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-sm-4 col-md-3">
    @include('user.cabinet.cabinet_menu')
    </div>
    <div class="col-xs-12 col-sm-8 col-md-9">
        @if (Session::has('message'))
            <div class="alert alert-success col-xs-12 col-sm-10 col-md-10">{{ Session::get('message') }}</div>
        @endif
        <form action="" method="post">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group{{ $errors->has('f_name') ? ' has-error' : '' }} col-xs-8 col-sm-8 col-md-5">
                <label for="f_name">Имя:</label>
                <input type="text" class="form-control" name="f_name" id="f_name" value="{{ $data['f_name'] }}">
            </div>
            <div class="form-group{{ $errors->has('l_name') ? ' has-error' : '' }} col-xs-8 col-sm-8 col-md-5">
                <label for="l_name">Фамилия:</label>
                <input type="text" class="form-control" name="l_name" id="l_name" value="{{ $data['l_name'] }}">
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-xs-8 col-sm-8 col-md-5">
                <label for="email">email:</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ $data['email'] }}">
            </div>
            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-xs-8 col-sm-8 col-md-5">
                <label for="pwd">Пол:</label>
                <select class="form-control" name="gender" id="gender">
                    <option @if($data['gender'] == 'Male') selected @endif value="Male">Мужской</option>
                    <option @if($data['gender'] == 'Female') selected @endif value="Female">Женский</option>
                </select>
            </div>
            <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }} col-xs-8 col-sm-8 col-md-5">
                <label for="pwd">Дата рождения: {{ $data['date_of_birth'] }}</label>
                <input type="text" class="form-control datepicker" name="date_of_birth" id="date_of_birth" data-date-format="yyyy-mm-dd" value="{{ $data['date_of_birth'] }}">
            </div>
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-xs-8 col-sm-8 col-md-5">
                <label for="phone">Телефон:</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ $data['phone'] }}">
            </div>
            <div class="form-group col-xs-10 col-sm-10 col-md-10">
                <button type="submit" class="btn btn-default">Сохранить</button>
            </div>
            <div class="form-group col-xs-10 col-sm-10 col-md-10">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </form>
        @if (count($delivery) != 0)
            <div class="col-xs-10 col-sm-10 col-md-10 list-group">
                    <strong class="list-group-item-heading">Адреса:</strong>

                <div class="col-xs-12 col-md-12 col-sm-12 list-group-item-heading">
                    <span class="col-xs-3 col-sm-3 col-md-3">Имя</span>
                    <span class="col-xs-3 col-sm-3 col-md-3">Телефон</span>
                    <span class="col-xs-3 col-sm-3 col-md-3">Адрес</span>
                    <span class="col-xs-3 col-sm-3 col-md-3">Дата</span>
                </div>
                @foreach ($delivery as $deliv)
                    <div class="col-xs-12 col-md-12 col-sm-12 list-group">
                        <span class="col-xs-3 col-sm-3 col-md-3">
                            {{ $deliv->orderDelivery['delivery_f_name'] }}
                            {{ $deliv->orderDelivery['delivery_l_name'] }}
                        </span>
                        <span class="col-xs-3 col-sm-3 col-md-3">{{ $deliv->orderDelivery['delivery_phone'] }}</span>
                        <span class="col-xs-3 col-sm-3 col-md-3">{{ $deliv->orderDelivery['delivery_address'] }}</span>
                        <span class="col-xs-3 col-sm-3 col-md-3">{{ $deliv->orderDelivery['created_at'] }}</span>
                    </div>
            @endforeach

                </div>
        @endif
    </div>

@endsection