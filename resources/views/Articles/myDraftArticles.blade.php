@extends('layouts.app')

@section('content')

<x-sidebar />
<h2 class="text-center mb-4" style="font-weight: bold; color: #4d467480; font-size: 23px; padding-bottom: 10px;">
    Drafts
</h2>
<div class="content">

    <div class="container py-5">

        <x-Errors/>
        @include('components.articles', ['articles' => $articles])
    </div>
</div>

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
