<?php
namespace App\Services;



use App\Models\Article;
use Illuminate\Support\Facades\DB;
use App\Enums\ArticleStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ArticleService
{
     public function get():array
     {
       $articles = Article::with(['photos', 'category'])
       ->where('status', 'published')
       ->orderBy('created_at', 'desc')
       ->get();

       return [
           'status' => 1,
           'data' => $articles,
           'message' => 'Products retrieved successfully.'
       ];
   }

   public function create(array $data, $photos = null) : array
   {
       $user = Auth::user();
       $article = Article::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'category_id' => $data['category_id'],
            'user_id' => $user->id,
            'status' => $data['status'],
    ]);


       if ($photos) {
           foreach ($photos as $photo) {
               try {

                   $path = $photo->store('uploads', 'public');
                   $article->photos()->create([
                       'image' => $path,
                   ]);
               } catch (\Exception $e) {
                   Log::error('Error saving image: ' . $e->getMessage());
               }
           }
       }
       return [
        'status' => 1,
        'data' => $article,
        'message' => 'Products retrieved successfully.'
    ];
   }

   public function my() : array
   {
    $user=Auth::user();

    $articles = Article::with(['photos', 'category'])
    ->where('user_id',$user->id)
    ->where('status', 'published')
    ->orderBy('created_at', 'desc')
    ->get();

    return [
        'status' => 1,
        'data' => $articles,
        'message' => 'Products retrieved successfully.'
    ];
   }

   public function drafts() : array
   {
    $user=Auth::user();

    $articles = Article::with(['photos', 'category'])
    ->where('user_id',$user->id)
    ->where('status', 'draft')
    ->orderBy('created_at', 'desc')
    ->get();

    return [
        'status' => 1,
        'data' => $articles,
        'message' => 'Products retrieved successfully.'
    ];
   }

   public function update(int $id, array $data, $photos = null): array
{
    $user = Auth::user();
    $article = Article::findOrFail($id);

    if ($article->user_id !== $user->id) {
        return [
            'status' => 0,
            'message' => 'Unauthorized action.',
        ];
    }

    // Check if the status is changing
    $isStatusChanged = $article->status !== $data['status'];

    $article->update([
        'title' => $data['title'],
        'body' => $data['body'],
        'category_id' => $data['category_id'],
        'status' => $data['status'] ?? $article->status,
        'created_at' => $isStatusChanged ? now() : $article->created_at,
    ]);

    if ($photos) {
        foreach ($photos as $photo) {
            try {
                $path = $photo->store('uploads', 'public');
                $article->photos()->create(['image' => $path]);
            } catch (\Exception $e) {
                Log::error('Error saving image: ' . $e->getMessage());
            }
        }
    }

    return [
        'status' => 1,
        'data' => $article,
        'message' => 'Article updated successfully.'
    ];
}

    public function delete($id)
    {
        $user = Auth::user();
        $article = Article::findOrFail($id);

        if ($article->user_id !== $user->id) {
            return [
                'status' => 0,
                'message' => 'Unauthorized action.',
            ];
        }

        foreach ($article->photos as $photo) {
            $photo->delete();
        }

        $article->delete();
        return [
            'status' => 1,
            'message' => 'Article deleted successfully.'
        ];
    }

    public function filter(array $filters): array
{
    $query = Article::with(['photos', 'category'])
        ->where('status', 'published');

    if (!empty($filters['title'])) {
        $query->where('title', 'like', '%' . $filters['title'] . '%');
    }

    if (!empty($filters['body'])) {
        $query->where('body', 'like', '%' . $filters['body'] . '%');
    }

    if (!empty($filters['category_id'])) {
        $query->where('category_id', $filters['category_id']);
    }

    $articles = $query->orderBy('created_at', 'desc')->get();

    return [
        'status' => 1,
        'data' => $articles,
        'message' => 'Articles filtered successfully.',
    ];
}


}
