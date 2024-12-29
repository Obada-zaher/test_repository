<div id="articles-container">
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
                <a href="{{ route('articles.edit', $article->id) }}"
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
                    <button
                        class="btn btn-like btn-sm d-flex align-items-center me-2"
                        data-article-id="{{ $article->id }}"
                        data-liked="{{ $article->likes->contains('user_id', Auth::id()) ? 'true' : 'false' }}">
                        <i class="bi bi-hand-thumbs-up-fill like-icon {{ $article->likes->contains('user_id', Auth::id()) ? 'text-primary' : 'text-secondary' }}"></i>
                        <span class="ms-1 like-count">{{ $article->likes->count() }}</span>
                    </button>
                <a href="#"
                class="btn btn-outline-secondary btn-sm d-flex align-items-center view-comments"
                data-article-id="{{ $article->id }}">
                    <i class="bi bi-chat-dots"></i>
                    <span class="ms-1">Comments</span>
                </a>

                </div>

                <div id="comments-{{ $article->id }}" class="comments-section d-none">
                    <div class="comments-container"></div>

                    <form id="add-comment-form-{{ $article->id }}" class="add-comment-form mt-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="comment" id="comment-input-{{ $article->id }}"
                                   class="form-control" placeholder="Add a comment..." required>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                    <button data-article-id="{{ $article->id }}"
                            data-page="2"
                            class="btn btn-link load-more-comments d-none mt-3">Load More Comments</button>
                </div>
        </div>

    </div>
</div>

@endforeach
</div>
@else
<p class="text-center text-muted">No articles available.</p>
@endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {

      if (window.location.pathname !== '/articles/filter') {
          let page = 2;
          const articlesContainer = document.getElementById('articles-container');
          const loadingSpinner = document.createElement('div');
          loadingSpinner.className = 'text-center py-4';
          loadingSpinner.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';
          let isLoading = false;
          window.addEventListener('scroll', function () {
              if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 100 && !isLoading) {
                  isLoading = true;
                  articlesContainer.appendChild(loadingSpinner);

                  fetch(`?page=${page}`, {
                      headers: {
                          'X-Requested-With': 'XMLHttpRequest',
                      },
                  })
                      .then(response => response.json())
                      .then(data => {
                          if (data.articles) {
                              articlesContainer.insertAdjacentHTML('beforeend', data.articles);
                              if (!data.hasMore) {
                                  window.removeEventListener('scroll', arguments.callee);
                              }
                              page++;
                          }
                      })
                      .catch(error => console.error('Error loading articles:', error))
                      .finally(() => {
                          isLoading = false;
                          articlesContainer.removeChild(loadingSpinner);
                      });
              }
          });
          articlesContainer.addEventListener('click', function (event) {
              if (event.target.closest('.btn-like')) {
                  handleLikeButton(event.target.closest('.btn-like'));
              } else if (event.target.closest('.view-comments')) {
                  handleCommentsButton(event.target.closest('.view-comments'));
              } else if (event.target.closest('.load-more-comments')) {
                  handleLoadMoreComments(event.target.closest('.load-more-comments'));
              }
          });
      }
      initializeCommentForms();
  });

  function handleLikeButton(button) {
      if (button.disabled) return;

      const articleId = button.getAttribute('data-article-id');
      const liked = button.getAttribute('data-liked') === 'true';
      button.disabled = true;

      fetch('/like', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ article_id: articleId, liked: !liked })
      })
          .then(response => response.json())
          .then(data => {
              if (data.status === 1) {
                  const likeCount = button.querySelector('.like-count');
                  const likeIcon = button.querySelector('.like-icon');

                  likeCount.textContent = parseInt(likeCount.textContent) + (liked ? -1 : 1);

                  button.setAttribute('data-liked', String(!liked));

                  likeIcon.classList.toggle('text-primary', !liked);
                  likeIcon.classList.toggle('text-secondary', liked);
              }
          })
          .finally(() => {
              button.disabled = false;
          });
  }

  function handleCommentsButton(button) {
      event.preventDefault();

      const articleId = button.getAttribute('data-article-id');
      const commentsSection = document.getElementById(`comments-${articleId}`);
      const commentsContainer = commentsSection.querySelector('.comments-container');
      const loadMoreButton = commentsSection.querySelector('.load-more-comments');

      if (!commentsSection.classList.contains('d-none')) {
          commentsSection.classList.add('d-none');
          return;
      }

      commentsContainer.innerHTML = '';
      loadComments(articleId, 1, commentsContainer, loadMoreButton);

      commentsSection.classList.remove('d-none');
  }

  function handleLoadMoreComments(button) {
      const articleId = button.getAttribute('data-article-id');
      const page = button.getAttribute('data-page');
      const commentsSection = document.getElementById(`comments-${articleId}`);
      const commentsContainer = commentsSection.querySelector('.comments-container');

      loadComments(articleId, page, commentsContainer, button);
  }
  function loadComments(articleId, page, commentsContainer, loadMoreButton) {
      fetch(`/articles/${articleId}/comments?page=${page}`, {
          method: 'GET',
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
      })
          .then(response => response.json())
          .then(data => {
              if (data.comments.length === 0 && page === 1) {
                  commentsContainer.innerHTML = '<p class="text-muted">No comments available.</p>';
              } else {
                  data.comments.forEach(comment => {
                      const commentHtml = `
                          <div class="comment mb-2 p-2 border rounded">
                              <strong>${comment.user.first_name} ${comment.user.last_name}:</strong>
                              <p>${comment.content}</p>
                          </div>
                      `;
                      commentsContainer.innerHTML += commentHtml;
                  });

                  if (data.hasMore) {
                      loadMoreButton.dataset.page = parseInt(page) + 1;
                      loadMoreButton.classList.remove('d-none');
                  } else {
                      loadMoreButton.classList.add('d-none');
                  }
              }
          })
          .catch(error => {
              console.error('Error fetching comments:', error);
          });
  }

  function toggleReadMore(articleId) {
      const articleBody = document.querySelector(`[data-article-id="${articleId}"]`);
      const fullBody = document.getElementById(`article-full-${articleId}`);

      if (fullBody.classList.contains('d-none')) {
          fullBody.classList.remove('d-none');
          articleBody.classList.add('d-none');
      } else {
          fullBody.classList.add('d-none');
          articleBody.classList.remove('d-none');
      }
  }

  function initializeCommentForms() {
    document.querySelectorAll('.add-comment-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const articleId = this.id.split('-').pop();
            const commentInput = document.getElementById(`comment-input-${articleId}`);
            const commentsContainer = document.querySelector(`#comments-${articleId} .comments-container`);

            postComment(articleId, commentInput.value, commentsContainer)
                .then(() => {
                    commentInput.value = ''; // Clear the input field after submission
                })
                .catch(error => console.error('Error adding comment:', error));
        });
    });
}

function postComment(articleId, commentContent, commentsContainer) {
    return fetch(`/articles/${articleId}/comments`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ comment: commentContent })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const commentHtml = generateCommentHTML(data.comment);
            commentsContainer.insertAdjacentHTML('afterbegin', commentHtml); // Add new comment to the top
        } else {
            alert('Failed to add comment.');
        }
    });
}

function generateCommentHTML(comment) {
    return `
        <div class="comment mb-2 p-2 border rounded">
            <strong>${comment.user.first_name} ${comment.user.last_name}:</strong>
            <p>${comment.content}</p>
        </div>
    `;
}
</script>
