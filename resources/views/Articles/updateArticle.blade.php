@extends('layouts.app')

@section('content')

<x-sidebar />

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card h-100 shadow-lg">
                <div class="card-body">
                    <h2 class="text-center mb-4" style="font-weight: bold; color: #4d467480; font-size: 23px; padding-bottom: 10px;">
                        Edit Articles
                    </h2>
                    <x-Errors/>
                    <form method="POST" action="{{ route('articles.update', $article->id) }}" enctype="multipart/form-data" id="articleForm">
                        @csrf

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Article Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $article->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Body -->
                        <div class="mb-3">
                            <label for="body" class="form-label fw-bold">Article Body</label>
                            <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="5" required>{{ old('body', $article->body) }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-bold">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="" disabled>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Images -->
                        <div class="mb-3">
                            <label for="photos" class="form-label fw-bold">Upload Photos</label>
                            <div id="photoInputs">
                                @foreach($article->photos as $photo)
                                <div class="photo-input-container">
                                    <input type="file" class="form-control mb-2 photo-input" name="photos[]" accept="image/*">
                                    <div>
                                        <img src="{{ asset('storage/' . $photo->image) }}" class="img-thumbnail me-2 mb-2" style="width: 100px; height: 100px;">
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-photo" data-photo-id="{{ $photo->id }}" onclick="removePhoto(this)">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                                <div class="photo-input-container">
                                    <input type="file" class="form-control mb-2 photo-input" name="photos[]" accept="image/*">
                                    <div id="photoPreviews" class="mb-3"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Publish</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">People will be able to see your article if it is published.</small>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-5">Update Article</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</div>
<script>
    function removePhoto(button) {
    const preview = button.parentElement;
    const input = preview.previousElementSibling;
    const container = input.parentElement;

    const photoId = button.getAttribute('data-photo-id');

    if (photoId) {
        fetch(`/photos/${photoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                container.remove();
            } else {
                console.error('Failed to delete photo');
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        container.remove();
    }
}
</script>
@endsection
