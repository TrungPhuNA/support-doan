<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;
use App\Models\Document;
use App\Models\Menu;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use App\Models\Slide;

class HomeController extends FrontendController
{
	public function index()
	{
		$documentsNews = Document::with('admin:id,name,slug')
			->where('dcm_active', '1')
			->select('id', 'dcm_name', 'dcm_slug', 'dcm_price', 'dcm_number', 'dcm_admin_id', 'dcm_view', 'dcm_ext', 'dcm_download', 'dcm_avatar')
			->limit(8)
			->orderByDesc('id')
			->get();

		// Lấy slide trang chủ
		$slides = Slide::where('sd_active', 1)
			->orderBy('sd_sort', 'asc')
			->get();

		// Bài viết thuộc menu hót
		$menuHot = Menu::where([
			'mn_hot'    => Menu::HOT,
			'mn_status' => Menu::STATUS_ACTIVE
		])->first();

		if ($menuHot) {
			$articles = Article::where([
				'a_menu_id' => $menuHot->id,
				'a_active'  => Article::STATUS_ACTIVE
			])->select('a_name', 'a_slug', 'id', 'a_avatar','a_description','created_at')
				->limit(4)
				->orderByDesc('id')
				->get();
		}

		$optionsMeta = [
			'meta_title'       => 'Tài liệu giảng dạy file word',
			'meta_robots'      => 'INDEX, FOLLOW',
			'meta_description' => 'Đề thi, chuyên đề, giáo án các môn toán, lý, hóa, anh, sinh, sử, địa file word',
			'meta_keywords'    => 'tài liệu, chia sẻ tài liệu, download tài liệu, tài liệu tham khảo, tài liệu miễn phí, giáo án điện tử, bài giảng điện tử và e-book , sách,sách online, biểu mẫu, văn bản, đồ án, luận văn, giáo trình',
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

		$viewData = [
			'slides'        => $slides,
			'documentsNews' => $documentsNews ?? [],
			'productsPay'   => $productsPay ?? [],
			'articles'      => $articles ?? [],
			'menuHot'       => $menuHot,
			'metaSeo'       => $metaSeo
		];

		return view('pages.home.index', $viewData);
	}
}
