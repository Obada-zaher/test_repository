@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <!-- Email Verification Notification -->
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-4 mx-auto"
                 style="background-color: #f8f9fa; max-width: 450px;">
                <div class="card-body p-4">
                    <h2 class="text-center mb-3" style="font-weight: bold; font-family: 'Poppins', sans-serif; color: #4d4c4c;">
                        {{ __('Email Verification') }}
                    </h2>
                    <p class="text-center text-muted">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success text-center mt-3" role="alert">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <!-- Resend Verification Email -->
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary rounded-pill"
                                    style="background-color: #6C63FF; border: none; font-weight: bold;">
                                {{ __('Resend Verification Email') }}
                            </button>
                        </form>

                        <!-- Log Out -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none text-muted fw-bold"
                                    style="font-size: 0.875rem;">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
