@if($articles->count() > 0)
@foreach($articles as $article)
<div class="col-12">
    <div class="card shadow-sm border-0">
        <div class="card-body d-flex flex-column flex-md-row align-items-start">

            @if($article->photos->count() > 0)
            <div class="me-md-4 flex-shrink-0" style="width: 65%; max-width: 500px;">
                <div id="carousel-{{ $article->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($article->photos as $key => $photo)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $photo->image) }}"
                                alt="Article Image"
                                class="d-block w-100 rounded shadow-sm"
                                style="object-fit: cover; height: 400px;">
                        </div>
                        @endforeach
                    </div>
                    @if($article->photos->count() > 1)
                    <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#carousel-{{ $article->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#carousel-{{ $article->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    @endif
                </div>
            </div>
            @endif

            <div class="flex-grow-1 d-flex flex-column justify-content-between">

                <p class="category-title mb-2">
                    <span class="badge rounded-pill text-black px-3 py-2" style="background-color: {{ $article->category->color ?? '#b8bec56c' }};">
                      {{ $article->category->name }}
                    </span>
                </p>

                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('profile.show', $article->user->id) }}" class="d-flex align-items-center text-decoration-none">
                        <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px;">
                            <img src="{{ $article->user->image ? asset('storage/' . $article->user->image) : asset('images/noprofile.png') }}"
                                 alt="User Image"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <span class="ms-2 fw-bold text-dark">{{ $article->user->first_name }} {{ $article->user->last_name }}</span>
                    </a>
                </div>

                @if(Auth::check() && Auth::id() == $article->user_id)
                <a href="{{ route('articles.create1', $article->id) }}"
                   class="btn btn-sm btn-outline-primary d-flex align-items-center position-absolute top-0 end-0 edit-button">
                    <i class="bi bi-pencil"></i>
                </a>

                <form action="{{ route('delete.article', $article->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this article?');"
                      class="position-absolute top-0 end-0 mt-5 delete-button">
                    @csrf
                    <button type="submit"
                            class="btn btn-sm btn-danger d-flex align-items-center">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            @endif

                <h5 class="fw-bold text-dark mb-2">{{ $article->title }}</h5>

                <p class="text-muted article-body" data-article-id="{{ $article->id }}">
                    {{ Str::limit($article->body, 150) }}
                    @if(strlen($article->body) > 150)
                    <span class="read-more" style="color: blue; cursor: pointer;" onclick="toggleReadMore({{ $article->id }})">Read more</span>
                    @endif
                </p>
                <p class="text-muted article-full-body d-none" id="article-full-{{ $article->id }}">
                    {{ $article->body }}
                    <span class="read-less" style="color: blue; cursor: pointer;" onclick="toggleReadMore({{ $article->id }})">Read less</span>
                </p>

                <div class="d-flex justify-content-start align-items-center mt-3">
                    <button class="btn btn-outline-primary btn-sm d-flex align-items-center me-2">
                        <i class="fas fa-thumbs-up"></i>
                    </button>
                    <a href="#" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        <i class="bi bi-chat-dots"></i>
                    </a>
                </div> 
            </div>
        </div>

    </div>
</div>
@endforeach
</div>
@else
<p class="text-center text-muted">No articles available.</p>
@endif
