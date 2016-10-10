@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-sm-4 col-md-3">
        @include('user.cabinet.cabinet_menu');
    </div>
    <div class="col-xs-12 col-sm-8 col-md-9">
        <h2>Управление рассылкой</h2>
    </div>
    @if(count($subscribations) != 0 )
    @if (Session::has('message'))
        <div class="alert alert-success col-xs-12 col-sm-8 col-md-9">{{ Session::get('message') }}</div>
    @endif
    <form action="/cabinet/subscribations" method="post">
    <input name="_method" type="hidden" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="col-xs-12 col-sm-8 col-md-9">
        @foreach($subscribations as $sub)
            @if(count($sub->subscribation) != 0)
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h3>{{ $sub->name }}</h3>
                <ul class="list-group">
                @foreach($sub->subscribation as $subs)
                    <li class="list-group-item">
                        <label>
                            <input type="checkbox" name="subscribation[]" value="{{ $subs->id }}" @if(isset($user_subscribations[$subs->id])) checked="checked" @endif>
                            {{ $subs->id }} {{ $subs->name }}
                        </label>
                    </li>
                @endforeach
                </ul>
            </div>
            @endif
        @endforeach
        <div class="col-xs12 col-sm-10 col-md-10">
            <button type="submit" class="btn btn-default">Сохранить</button>
        </div>
    </div>
    </form>
    @endif
@endsection