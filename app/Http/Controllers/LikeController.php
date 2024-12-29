<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Services\LikeService;
use App\Http\Responses\Response;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function liked(Request $request)
    {
        try {
            $response = $this->likeService->liked($request->all());
            if (!isset($response['data'])) {
                return Response::Error([], 'No data found.');
            }
            return response()->json($response);
        } catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error([], $message);
        }
    }
}
