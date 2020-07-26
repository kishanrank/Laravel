@extends('layouts.app')
@section('content')
<div class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>Admin Login <br> K.M.R@NK's Blog </b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form method="POST" action="{{ route($loginRoute) }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
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
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" value="{{ old('remember') ? 'checked' : '' }}">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                @if (Route::has('admin.password.request'))
                <p class="mb-1">
                    <a href="{{ route($forgotPasswordRoute) }}">Forgot Password?</a>
                </p>
                @endif
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</div>
@endsection
@section('script')
@include('admin.auth.includes.sweetalert')
@endsection