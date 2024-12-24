@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <!-- Left Side: Registration Form -->
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-4 mx-auto"
                 style="background-color: #f8f9fa; max-width: 450px;">
                <div class="card-body p-4">
                    <h2 class="text-center mb-3" style="font-weight: bold; font-family: 'Poppins', sans-serif; color: #4d4c4c;">
                        {{ __('Create an Account') }}
                    </h2>
                    <p class="text-center text-muted mb-4">
                        {{ __('Already have an account?') }}
                        <a href="{{ route('login') }}" class="text-primary fw-bold">{{ __('Login') }}</a>
                    </p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="first_name" class="form-label text-muted">{{ __('First Name') }}</label>
                            <input id="first_name" type="text"
                                   class="form-control rounded-pill @error('first_name') is-invalid @enderror"
                                   name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label text-muted">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text"
                                   class="form-control rounded-pill @error('last_name') is-invalid @enderror"
                                   name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-muted">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                   class="form-control rounded-pill @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                   name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label text-muted">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control rounded-pill" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill" style="background-color: #6C63FF; border: none; font-weight: bold;">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side: Illustration -->
        <div class="col-lg-6 d-none d-lg-block">
            <div class="text-center">
                <img src="images/register.svg" class="side-image" alt="Responsive Image"
                     style="border-radius: 0 20px 20px 0; object-fit: cover; max-height: 90vh;">
            </div>
        </div>
    </div>
</div>
@endsection
