<?php

namespace Core\Blog\Http\Controllers;

use App\Models\Article;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;

class HomeBlogController extends BaseBlogController
{
	public function index()
	{
		//  Danh sách bài viết
		$articles = Article::with('admin:id,name,avatar')->where([
			'a_active' => 1
		])
			->select('id', 'a_name', 'a_slug', 'a_description', 'a_avatar', 'a_admin_id', 'created_at')
			->where('a_position_1',0)
			->orderByDesc('id')
			->paginate(10);

		//Bài viết nổi bật trung tâm
		$articlesHotTop = Article::where([
			'a_active'     => 1,
			'a_position_1' => 1
		])
			->select('id', 'a_name', 'a_slug', 'a_description', 'a_avatar')
			->orderByDesc('id')
			->limit(5)
			->get();


		$optionsMeta = [
			'meta_title'       => 'Trang tin tức - Chuyên chia sẻ, cung cấp tài liệu, các dạng đề thi mới nhất',
			'meta_description' => 'Cung cấp tài liệu, đề thi các môn Toán, Lý, Hoá, Sinh, Tiếng Anh tất cả các năm',
			'meta_robots'      => ''
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

		$viewData = [
			'articles'              => $articles,
			'metaSeo'               => $metaSeo,
			'tags'                  => $this->getTags(),
			'articlesHot'           => $this->getArticleHot(),
			'articlesHotSidebarTop' => $this->getArticleTopSidebar(),
			'articlesHotTop'        => $articlesHotTop,
			'menus'                 => $this->getMenus()
		];

		return view('blog::home.index', $viewData);
	}
}