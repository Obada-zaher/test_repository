
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
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-comment-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const articleId = this.id.split('-').pop();
            const commentInput = document.getElementById(`comment-input-${articleId}`);
            const commentsContainer = document.querySelector(`#comments-${articleId} .comments-container`);

            fetch(`/articles/${articleId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ comment: commentInput.value })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const commentHtml = `
                        <div class="comment mb-2 p-2 border rounded">
                            <strong>${data.comment.user.first_name} ${data.comment.user.last_name}:</strong>
                            <p>${data.comment.content}</p>
                        </div>
                    `;
                    commentsContainer.innerHTML = commentHtml + commentsContainer.innerHTML;
                    commentInput.value = ''; // Clear the input field
                } else {
                    alert('Failed to add comment.');
                }
            })
            .catch(error => {
                console.error('Error adding comment:', error);
            });
        });
    });
});
