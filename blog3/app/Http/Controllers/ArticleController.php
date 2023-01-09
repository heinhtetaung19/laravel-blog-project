<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }

    public function index()
    {
        // $data = [
        //     ['title' => 'Title One'],
        //     ['title' => 'Title Two'],
        //     ['title' => 'Title Three'],
        // ];

        // $data = Article::all();
        $data = Article::latest()->paginate(5);

        return view('articles.index', [
            'articles' => $data
        ]);
    }

    public function detail($id)
    {
        // return "Article controller detail : $id";
        $article = Article::find($id);

        return view('/articles.detail', [
            'article' => $article
        ]);
    }

    public function add()
    {
        return view("articles.add");
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            "title" => "required",
            "body" => "required",
            "category_id" => "required",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save();

        return redirect('/articles');
    }

    public function delete($id)
    {
        $article = Article::find($id);

        if (Gate::allows('article-delete', $article)) {
            $article->delete();
            return redirect('/articles')->with("info", "An article was deleted");
        }

        return back()->with("info", "No permission to delete");
    }
}
