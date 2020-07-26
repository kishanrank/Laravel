@extends('layouts.app')

@section('content')
<div class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>Reset Password</b></a>
    </div>
  <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="input-group mb-3">
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" placeholder="Password">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="input-group mb-3">
                    <input id="password-confirm" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                @error('password_confirmation')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Change password</button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route('admin.login')}}">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection
@section('script')
    @include('admin.auth.includes.sweetalert')
@endsection