@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card h-100 shadow-lg">
                <div class="card-img-top position-relative d-flex justify-content-center align-items-center"
                     style="height: 200px; background-color: #f8f9fa;">
                    <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/noprofile.png') }}"
                         alt="Profile Image"
                         class="rounded-circle shadow-sm border"
                         style="object-fit: cover; width: 150px; height: 150px; max-width: 100%; max-height: 100%;">
                </div>
                <div class="card-body text-center">
                    <h4 class="card-title fw-bold text-truncate">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h4>
                    <p class="card-text text-muted mb-2">{{ Auth::user()->email }}</p>
                    <p class="card-text text-muted mb-2">Phone: {{ Auth::user()->phone ?? 'Not Provided' }}</p>
                    <p class="card-text text-muted mb-2">Username: {{ Auth::user()->username ?? 'Not Provided' }}</p>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="/profile/edit" class="btn btn-primary mx-2">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
