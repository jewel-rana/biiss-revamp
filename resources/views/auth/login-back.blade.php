@extends('layouts.login_app')
@section('content')


    <!--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

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
                                <input id="password" type="password" class="form-control" name="password" required>

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
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->



<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);"><b>BIISS LOGIN</b></a>

    </div>
    <div class="card">
        <div class="body">

            <form id="sign_in" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                <div class="msg"></div>
                <div class="input-group">
                        <span class="input-group-addon">

                            <i class="material-icons">person</i>
                        </span>
                    <div class="form-line">

                        <input id="email" placeholder="Email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                    <div class="form-line">
                       <input id="password" placeholder="Password" type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="">
                    <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                </div>
                <div class="row">
                    <!--<div class="col-xs-8 p-t-5">
                        <input type="checkbox" class="filled-in chk-col-pink" id="rememberme"  name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="rememberme">Remember Me</label>
                    </div>-->

                    <!--<div class="col-xs-12">
                        <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                    </div>-->
                </div>
                <div class="row m-t-15 m-b--20">
                   <!-- <div class="col-xs-6">
                        <a href="{{ url('/register') }}">Register Now!</a>
                    </div>-->
                   <!-- <div class="col-xs-6 align-right">

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    </div>-->
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
