@extends('auth.auth_layout')
@push('css')
<style>
    body,
    html {
        height: 100%;
        margin: 0;
        overflow: hidden;
    }

    body {
        /* background-image: url('http://127.0.0.1:8000/pos/dist/img/login_bg.jpg'); */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        /* Adjust the last value for opacity */
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Adjust the last value for overlay opacity */
    }
</style>
@endpush
@section('auth_content')
<div class="login-box w-25">
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <div class="login-logo">
                <b>Admin</b>LTE</a>
            </div>
            <p class="login-box-msg">{{translate('Sign in to start your session')}}</p>
            @if ($errors->any())
            <p class="login-box-msg text-red"><b>{{translate('Invalid credentials')}}</b></p>
            @endif
            <form action="{{route('login')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                {{translate('Remember Me')}}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">{{translate('Sign In')}}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="forgot-password.html">{{translate('I forgot my password')}}</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection