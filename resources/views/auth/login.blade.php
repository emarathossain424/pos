@extends('auth.auth_layout')
@push('css')
@endpush
@section('auth_content')
<div class="row align-items-center container-fluid" style="height: 100vh;">
    <!-- Login form -->
    <div class="col-md-4 p-5">
        <div class="login-logo">
            <b>Admin</b>LTE
        </div>
        <p class="login-box-msg">{{ translate('Sign in to start your session') }}</p>
        @if ($errors->any())
        <p class="login-box-msg text-red"><b>{{ translate('Invalid credentials') }}</b></p>
        @endif
        <form action="{{ route('login') }}" method="post">
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
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">{{ translate('Sign In') }}</button>
                </div>
            </div>
        </form>
        <p class="mt-2">
            {{ translate('Forgot your password? ') }}<a href="{{route('password.request')}}">{{ translate('Try forgot password link') }}</a>
        </p>
    </div>
    <!-- Login form -->
    <div class="col-md-8" style="background-image: url('/pos/dist/img/login_bg.jpg'); background-size: cover; background-position: center; max-width: 100%; height: 100vh;">
    </div>
</div>

@endsection