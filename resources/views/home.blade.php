@extends('layouts.app')

@section('content')

<x-sidebar />
<h2 class="text-center mb-4" style="font-weight: bold; color: #4d467480; font-size: 23px; padding-bottom: 10px;">
    Home
</h2>
<div class="content">
    <div class="container py-5">
        @include('components.articlefilter', ['articles' => $articles],['categories'=>$categories])
        </form>
        <div class="row g-4">
            <x-Errors/>
            <div id="articles-container">
                @include('components.articles', ['articles' => $articles])
            </div>
        </div>
    </div>
</div>
@endsection
