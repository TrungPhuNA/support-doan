<?php

namespace Core\Blog\Http\Controllers;

use App\Models\Article;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;

class ArticleDetailBlogController extends BaseBlogController
{
	public function index($id)
	{
		$article        = Article::with('menu:id,mn_name,mn_slug','admin:id,name,avatar')->find($id);
		$articleSuggest = Article::where("a_menu_id", $article->a_menu_id)
			->select('id', 'a_name', 'a_slug')
			->limit(10)
			->orderByDesc('id')
			->get();

		$optionsMeta = [
			'meta_title'       => $article->a_name,
			'meta_description' => $article->a_description,
			'meta_image'       => $article->a_avatar ? pare_url_file($article->a_avatar) : '',
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

		$viewData = [
			'article'               => $article,
			'metaSeo'               => $metaSeo,
			'articleSuggest'        => $articleSuggest,
			'articlesHotSidebarTop' => $this->getArticleTopSidebar(),
			'articlesHot'           => $this->getArticleHot(),
			'menus'                 => $this->getMenus()
//				'productTopPay'         => $this->getProductTop() ?? []
		];

		return view('blog::article_detail.index', $viewData);
	}
}