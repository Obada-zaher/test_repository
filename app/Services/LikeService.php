<?php
namespace App\Services;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function liked($request)
    {
        $user = Auth::user();

        $like = Like::where('user_id', $user->id)
                    ->where('article_id', $request['article_id'])
                    ->first();

        if ($like) {
            $like->delete();
            return [
                'status' => 1,
                'data' => [],
                'message' => 'Article unliked successfully.'
            ];
        } else {
            Like::create([
                'liked' => true,
                'user_id' => $user->id,
                'article_id' => $request['article_id']
            ]);
            return [
                'status' => 1,
                'data' => [],
                'message' => 'Article liked successfully.'
            ];
        }
    }

}
