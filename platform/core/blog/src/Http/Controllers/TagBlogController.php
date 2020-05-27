<?php

namespace Core\Blog\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;

class TagBlogController extends BaseBlogController
{
	public function index($id)
	{
		$tag = Tag::findOrFail($id);
		if (!$tag) return redirect()->to('/');

		$articles = Article::whereHas('tags', function ($query) use ($tag) {
			$query->where('at_tag_id', $tag->id);
		})->select('id', 'a_name', 'a_slug', 'a_description', 'a_avatar', 'a_menu_id')
			->orderByDesc('id')
			->simplePaginate(10);

		$optionsMeta = [
			'meta_title'       => $tag->t_name,
			'meta_description' => $tag->t_description,
		];

		$metaSeo = RenderMetaSeo::MetaSeo($optionsMeta);

		$viewData = [
			'articles'              => $articles,
			'tag'                   => $tag,
			'tags'                  => $this->getTags(),
			'articlesHot'           => $this->getArticleHot(),
			'articlesHotSidebarTop' => $this->getArticleTopSidebar(),
			'metaSeo'               => $metaSeo
		];

		return view('blog::home.index', $viewData);
	}
}