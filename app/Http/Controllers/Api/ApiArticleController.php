<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ProcessViewService;
use Illuminate\Http\Request;

class ApiArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$articles = Article::with('menu')->paginate(10);
    	return  $articles;
    }

    public function getArticleByMenuId(Request $request,$id)
	{
		$articles = Article::with('menu')
			->where('a_menu_id', $id)
			->paginate(10);

		return  $articles;
	}

    public function getArticleRelateByMenuId($id){
        $articles = Article::with('menu')
            ->where('a_menu_id', $id)
            ->limit(6)
            ->get();

        return  $articles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
		ProcessViewService::view('articles','a_view','article_'. $article->id,$article->id);
		return $article;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
