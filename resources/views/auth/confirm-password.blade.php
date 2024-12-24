@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <!-- Password Confirmation Form -->
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-4 mx-auto"
                 style="background-color: #f8f9fa; max-width: 450px;">
                <div class="card-body p-4">
                    <h2 class="text-center mb-3" style="font-weight: bold; font-family: 'Poppins', sans-serif; color: #4d4c4c;">
                        {{ __('Confirm Password') }}
                    </h2>
                    <p class="text-center text-muted">
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}" class="mt-3">
                        @csrf

                        <!-- Password -->
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

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill"
                                    style="background-color: #6C63FF; border: none; font-weight: bold;">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
