<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
              
    $articles = Article::orderBy('created_at', 'desc')->get();
    return Inertia::render('Articles/articlesView', [
        'articles' => $articles,
        'status' => session('status'),]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        dd($request->all());

           Article::create($request->all());
           return redirect(route('articles.index'));
   
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($article)
    {
        $article_data = Article::where('tipe', $article)->first();
        //edit article
        return Inertia::render('Articles/articleEdit', [
            'article' => $article_data,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //update article
        $article->update($request->all());
        return redirect(route('articles.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
