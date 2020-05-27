<?php


namespace Core\Blog\Http\Controllers;

use App\Models\Article;
use App\Models\Menu;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;

class MenuBlogController extends BaseBlogController
{
	public function index($id)
	{
		//  Danh sách bài viết
		$articles = Article::where([
			'a_active'  => 1,
			'a_menu_id' => $id
		])
			->select('id', 'a_name', 'a_slug', 'a_description', 'a_avatar')
			->orderByDesc('id')
			->paginate(10);

		$menu = Menu::find($id);

		$optionsMeta = [
			'meta_title'       => $menu->mn_name,
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_image'       => '',
			'meta_robots'      => ''
		];

		$metaSeo = RenderMetaSeo::MetaSeo($optionsMeta);

		$viewData = [
			'articles'              => $articles,
			'menu'                  => $menu,
			'metaSeo'               => $metaSeo,
			'articlesHotSidebarTop' => $this->getArticleTopSidebar(),
			'articlesHot'           => $this->getArticleHot()
		];

		return view('blog::home.index', $viewData);
	}
}