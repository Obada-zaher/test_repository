@extends('layouts.app')

@section('content')

<x-sidebar />
<h2 class="text-center mb-4" style="font-weight: bold; color: #4d467480; font-size: 23px; padding-bottom: 10px;">
    Home
</h2>
<div class="content">
    <div class="container py-5">
        <form method="GET" action="{{ route('articles.filter') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="title" class="form-control" placeholder="Search by title" value="{{ request('title') }}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="body" class="form-control" placeholder="Search by body" value="{{ request('body') }}">
                </div>
                <div class="col-md-4">
                    <select name="category_id" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>

        </form>
        <div class="row g-4">
            <x-Errors/>
            @include('components.articles', ['articles' => $articles])
        </div>
    </div>
</div>

@endsection
