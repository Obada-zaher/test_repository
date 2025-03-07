@extends('layouts.app')

@section('content')

<x-sidebar />
<x-Errors/>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card h-100 shadow-lg">
                <div class="card-body">
                    <h2 class="text-center mb-4" style="font-weight: bold; color: #4d467480; font-size: 23px; padding-bottom: 10px;">
                        Create New Article
                    </h2>
                    <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data" id="articleForm">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Article Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label fw-bold">Article Body</label>
                            <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="5" required>{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-bold">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photos" class="form-label fw-bold">Upload Photos</label>
                            <div id="photoInputs">
                                <input type="file" class="form-control mb-2 photo-input" name="photos[]" accept="image/*">
                                <div id="photoPreviews" class="mb-3"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary px-5" name="status" value="published">Publish Article</button>
                            <button type="submit" class="btn btn-secondary px-5" name="status" value="draft">Save as Draft</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection
