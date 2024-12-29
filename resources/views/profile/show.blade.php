@extends('layouts.app')

@section('content')

<x-sidebar />

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card h-100 shadow-lg">
                <div class="card-img-top position-relative d-flex justify-content-center align-items-center"
                     style="height: 200px; background-color: #f8f9fa;">
                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/noprofile.png') }}"
                         alt="Profile Image"
                         class="rounded-circle shadow-sm border"
                         style="object-fit: cover; width: 150px; height: 150px; max-width: 100%; max-height: 100%;">
                </div>
                <div class="card-body text-center">
                    <h4 class="card-title fw-bold text-truncate">{{ $user->first_name . ' ' . $user->last_name }}</h4>
                    <p class="card-text text-muted mb-2">{{ $user->email }}</p>
                    <p class="card-text text-muted mb-2">Phone: {{ $user->phone ?? 'Not Provided' }}</p>
                    <p class="card-text text-muted mb-2">Username: {{ $user->username ?? 'Not Provided' }}</p>

                    @if($isCurrentUser)
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{route('profile.edit')}}" class="btn btn-primary mx-2">Edit Profile</a>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="articles-section mt-5">
        <h2 class="text-center mb-4" style="font-weight: bold; color: #4d467480; font-size: 23px; padding-bottom: 10px;">
            Published Articles
        </h2>
        @include('components.articles', ['articles' => $articles])
    </div>
</div>
    </div>
</div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection

<script>
    function toggleReadMore(articleId) {
        const shortBody = document.querySelector(`.article-body[data-article-id="${articleId}"]`);
        const fullBody = document.getElementById(`article-full-${articleId}`);

        if (shortBody.classList.contains('d-none')) {
            shortBody.classList.remove('d-none');
            fullBody.classList.add('d-none');
        } else {
            shortBody.classList.add('d-none');
            fullBody.classList.remove('d-none');
        }
    }
</script>
