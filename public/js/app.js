document.addEventListener('DOMContentLoaded', function () {
    if (window.location.pathname !== '/articles/filter'  ) {
        initializeCommentForms();
        let page = 2;
        const articlesContainer = document.getElementById('articles-container');
        const loadingSpinner = document.createElement('div');
        loadingSpinner.className = 'text-center py-4';
        loadingSpinner.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';
        let isLoading = false;
        window.addEventListener('scroll', function onScroll() {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 50 && !isLoading) {
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
                            if (data.articles.length < 10 || !data.hasMore) {
                                window.removeEventListener('scroll', onScroll);
                            }
                            initializeCommentForms();
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

    function handleFileInput(input) {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = input.nextElementSibling;
                    preview.innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail me-2 mb-2" style="width: 100px; height: 100px;">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-photo" onclick="removePhoto(this)">Remove</button>
                    `;
                };
                reader.readAsDataURL(this.files[0]);
                const newInputContainer = document.createElement('div');
                newInputContainer.className = 'photo-input-container';
                const newInput = document.createElement('input');
                newInput.type = 'file';
                newInput.name = 'photos[]';
                newInput.accept = 'image/*';
                newInput.className = 'form-control mb-2 photo-input';
                newInputContainer.appendChild(newInput);
                newInputContainer.appendChild(document.createElement('div'));
                input.parentElement.parentElement.appendChild(newInputContainer);
                handleFileInput(newInput);
            }
        });
    }

    function removePhoto(button) {
        const preview = button.parentElement;
        const input = preview.previousElementSibling;
        const container = input.parentElement;
        container.remove();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const initialInput = document.querySelector('.photo-input');
        handleFileInput(initialInput);
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profileImage');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
