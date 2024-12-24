@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">

        <!-- Left Side: Login Form -->
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4" style="font-weight: bold; font-family: 'Poppins', sans-serif;">
                        {{ __('Welcome Back') }}
                    </h2>
                    <p class="text-center text-muted">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary fw-bold">{{ __('Sign Up') }}</a>
                    </p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="login" class="form-label">{{ __('Email, Username, or Phone') }}</label>
                            <input id="login" type="text" class="form-control @error('login') is-invalid @enderror"
                                   name="login" value="{{ old('login') }}" required autofocus>
                            @error('login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Right Side: Illustration -->
        <div class="col-lg-6 d-none d-lg-block">
            <div class="text-center">
                <img src="images/login.svg" class="side-image" alt="Responsive Image">
            </div>
        </div>
    </div>
</div>
@endsection
