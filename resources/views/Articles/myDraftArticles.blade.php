@extends('layouts.app')

@section('content')

<x-sidebar />

<div class="content">
    <div class="container py-5">
        <h2 class="text-center mb-4" style="font-weight: bold; color: #4d467480; font-size: 23px; padding-bottom: 10px;">
        Drafts
        </h2>
        <x-Errors/>
        @include('components.articles', ['articles' => $articles])
    </div>
</div>

@endsection
