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
                    <form method="POST" action="{{ route('login') }}" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label text-muted">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                   class="form-control rounded-pill @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-muted">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                   class="form-control rounded-pill @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill"
                                    style="background-color: #6C63FF; border: none; font-weight: bold;">
                                {{ __('Login') }}
                            </button>
                        </div>
                        @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a class="text-decoration-none text-primary fw-bold" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                        @endif
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
