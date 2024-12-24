@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <!-- Password Reset Request Form -->
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-4 mx-auto"
                 style="background-color: #f8f9fa; max-width: 450px;">
                <div class="card-body p-4">
                    <h2 class="text-center mb-3" style="font-weight: bold; font-family: 'Poppins', sans-serif; color: #4d4c4c;">
                        {{ __('Forgot Password?') }}
                    </h2>
                    <p class="text-center text-muted">
                        {{ __('Enter your email address below and we will send you a link to reset your password.') }}
                    </p>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success text-center rounded-pill" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="mt-3">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label text-muted">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                   class="form-control rounded-pill @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill"
                                    style="background-color: #6C63FF; border: none; font-weight: bold;">
                                {{ __('Email Password Reset Link') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
