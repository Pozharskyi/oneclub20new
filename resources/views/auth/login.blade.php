@extends('layouts.app')

@section('content')

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/auth/login.css') }}" />
    <script type="text/javascript" src="{{ asset('/js/auth/login.js') }}"></script>

    <div class="container" style="margin: 40px auto 40px auto;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">

                        <div class="text-center" style="margin-bottom: 25px;">
                            <h4>Вы еще не зарегестрированы?
                                <a href="{{ url('/register') }}">
                                    Зарегестрироватся
                                </a>
                            </h4>
                        </div>

                        <div class="text-center social-auth">

                            @foreach ( $social as $photo => $link )
                                <a onclick="popupCenter('{{ $link }}', 'Oneclub Social Auth', 600, 400)" href="javascript: void(0);">
                                    <img src="{{ $photo }}" width="40" height="40" />
                                </a>
                            @endforeach

                        </div>

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

@endsection
