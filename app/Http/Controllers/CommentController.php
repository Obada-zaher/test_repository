<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    public function get(Article $article, Request $request): JsonResponse
    {
        try {
            $perPage = 4;
            $page = $request->query('page', 1);
            $comments = $this->commentService->get($article, $perPage, $page);
            return response()->json([
                'status' => 'success',
                'comments' => $comments->items(),
                'hasMore' => $comments->hasMorePages(),
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch comments.',
            ], 500);
        }
    }

    public function create(Request $request, $articleId)
{
    $request->validate([
        'comment' => 'required|string|max:255',
    ]);

    $comment = Comment::create([
        'article_id' => $articleId,
        'user_id' => Auth::id(),
        'content' => $request->comment,
    ]);

    return response()->json([
        'success' => true,
        'comment' => [
            'user' => [
                'first_name' => Auth::user()->first_name,
                'last_name' => Auth::user()->last_name,
            ],
            'content' => $comment->content,
        ],
    ]);
}

}
