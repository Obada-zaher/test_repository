<?php
namespace App\Services;



use App\Models\Article;
use App\Models\Comment;
use App\Enums\ArticleStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
    public function get(Article $article, int $perPage = 4, int $page = 1): LengthAwarePaginator
    {
        return $article->comments()
            ->orderBy('created_at', 'desc')
            ->with('user:id,first_name,last_name,username')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
