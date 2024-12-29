<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Photo;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Responses\Response;
use App\Services\ArticleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreArticleRequest;

class ArticleController extends Controller
{
    private ArticleService $articleService;
    // constructor
    public function __construct(ArticleService $articleService)
    {

        $this->articleService = $articleService;
    }

    public function get(Request $request)
    {
        try {
            $response = $this->articleService->get();
            if (!isset($response['data'])) {
                return Response::Error([], 'No data found.');
            }
            $articles = $response['data'];
            $categories = Category::select('id','name')->get();
            if ($request->ajax()) {
                return response()->json([
                    'articles' => view('components.articles', ['articles' => $articles])->render(),
                    'hasMore' => $articles->hasMorePages(),
                ]);
            }
            return view('home', compact('articles', 'categories'));
        } catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error([], $message);
        }
    }

    public function my()
    {
        try {
            $response = $this->articleService->my();
            if (!isset($response['data'])) {
                return Response::Error([], 'No data found.');
            }
            $articles = $response['data'];
            $categories = Category::select('id','name')->get();
            return view('Articles.myPublishedArticles', compact('articles','categories'));
        } catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error([], $message);
        }
    }

    public function drafts()
    {
        try {
            $response = $this->articleService->drafts();
            if (!isset($response['data'])) {
                return Response::Error([], 'No data found.');
            }
            $articles = $response['data'];
            $categories = Category::select('id','name')->get();
            return view('Articles.myDraftArticles', compact('articles','categories'));
        } catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error([], $message);
        }
    }

    public function create()
    {
        $categories = Category::select('id','name')->get();
        return view('Articles.createArticle', compact('categories'));
    }

    public function store(StoreArticleRequest $request)
    {
        try {
            $data = $request->validated();
            $data['status'] = $request->input('status', 'draft');
            $this->articleService->create($data, $request->file('photos'));

            $message = $data['status'] === 'published'
                ? 'Article published successfully!'
                : 'Article saved as draft successfully!';

            if ($data['status'] === 'published') {
                return redirect()->route('my.articles')->with('success', $message);
            } else {
                return redirect()->route('draft.articles')->with('success', $message);
            }
        } catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error([], $message);
        }
    }

    public function edit($id)
    {
        $categories = Category::select('id','name')->get();
        $article = Article::findOrFail($id);
        return view('Articles.updateArticle', compact('categories', 'article'));
    }

    public function update(StoreArticleRequest $request, $id)
    {
        try {
            $article = Article::findOrFail($id);
            $response = $this->articleService->update($id, $request->validated(), $request->file('photos'));
            if ($response['code'] === 200) {
                $redirectRoute = $article->status === 'draft' ? 'draft.articles' : 'my.articles';
                return redirect()->route($redirectRoute)->with('success', 'Article updated successfully!');
            } else {
                return redirect()->back()->with('error', $response['message']);
            }
        } catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error([], $message);
        }
    }

    public function delete($id)
    {
        try {
            $article = Article::findOrFail($id);
            $response = $this->articleService->delete($id);

            if ($response['code'] === 200) {
                $redirectRoute = $article->status === 'draft' ? 'draft.articles' : 'my.articles';
                return redirect()->route($redirectRoute)->with('success', 'Article deleted successfully!');
            } else {
                return redirect()->back()->with('error', $response['message']);
            }
        } catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error([], $message);
        }
    }

    public function filter(Request $request)
    {
        try {
            $response = $this->articleService->filter($request->all());
            $articles = $response['data'];
            $categories = Category::all();
            return view('home', compact('articles', 'categories'));
        } catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error([], $message);
        }
    }

   public function deletePhoto($id)
    {
        try {
            $this->articleService->deletePhoto($id);
            return response()->json(['message' => 'Photo deleted successfully'], 200);
        } catch (Throwable $throwable) {
            $message = $throwable->getMessage();
            return Response::Error([], $message);
        }

    }
}
