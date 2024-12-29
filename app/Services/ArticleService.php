<?php
namespace App\Services;
use App\Models\Photo;
use App\Models\Article;
use App\Enums\ArticleStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class ArticleService
{
     public function get() : array
     {
       $articles = Article::with(['photos:id,image,article_id', 'category:id,name'])
       ->select('id', 'title', 'body', 'category_id', 'user_id', 'status', 'created_at')
       ->where('status', 'published')
       ->orderBy('created_at', 'desc')
       ->paginate(10);;

       $message = 'articles retrieved successfully.';
       $code = 200;
       return ['data' => $articles, 'message' => $message, 'code' => $code];

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
       $message = 'article created successfully.';
       $code = 201;
       return ['data' => $article, 'message' => $message, 'code' => $code];

   }

   public function my() : array
   {
    $user=Auth::user();

    $articles = Article::with(['photos:id,image,article_id', 'category:id,name'])
    ->select('id', 'title', 'body', 'category_id', 'user_id', 'status', 'created_at')
    ->where('user_id',$user->id)
    ->where('status', 'published')
    ->orderBy('created_at', 'desc')
    ->get();

    $message = 'articles retrieved successfully.';
    $code = 200;
    return ['data' => $articles, 'message' => $message, 'code' => $code];

   }

   public function drafts() : array
   {
    $user=Auth::user();

    $articles = Article::with(['photos:id,image,article_id', 'category:id,name'])
    ->select('id', 'title', 'body', 'category_id', 'user_id', 'status', 'created_at')
    ->where('user_id',$user->id)
    ->where('status', 'draft')
    ->orderBy('created_at', 'desc')
    ->get();

    $message = 'articles retrieved successfully.';
       $code = 200;
       return ['data' => $articles, 'message' => $message, 'code' => $code];

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

        $message = 'article updated successfully.';
        $code = 200;
        return ['data' => $article, 'message' => $message, 'code' => $code];

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
        foreach ($article->likes as $like) {
            $like->delete();
        }
        foreach ($article->comments as $comment) {
            $comment->delete();
        }

        $article->delete();

       $message = 'article deleted successfully.';
       $code = 200;
       return ['data' => [], 'message' => $message, 'code' => $code];

    }

    public function filter(array $filters): array
    {
        $query = Article::with(['photos:id,image,article_id', 'category:id,name'])
            ->select('id', 'title', 'body', 'category_id', 'user_id', 'status', 'created_at')
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

       $message = 'articles filtered successfully.';
       $code = 200;
       return ['data' => $articles, 'message' => $message, 'code' => $code];

    }

    public function deletePhoto(int $photoId): void
    {
        $photo = Photo::findOrFail($photoId);
        if (Storage::disk('public')->exists($photo->image)) {
            Storage::disk('public')->delete($photo->image);
        }
        $photo->delete();
    }


}
