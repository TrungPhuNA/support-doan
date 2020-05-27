<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ComboDocument;
use App\Models\Document;
use App\Models\Event;
use Illuminate\Http\Request;

class AjaxHomeController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 * Lấy sản phẩm thuộc danh mục nổi bật
	 */
	public function getLoadProductByCategory(Request $request)
	{
//		if ($request->ajax()) {
		// Sản phẩm thuộc danh mục hot
		$categoriesHot = Category::where([
			'c_hot'    => 1,
			'c_status' => 1
		])->select('c_name', 'id', 'c_slug')
			->limit(4)
			->get()
			->toArray();

		$categories[] = [
			'category'  => [],
			'documents' => []
		];
		if ($categoriesHot) {
			foreach ($categoriesHot as $category) {
				$document = Document::where([
					'dcm_active'      => Document::STATUS_ACTIVE,
					'dcm_category_id' => $category['id']
				])->select('id', 'dcm_name', 'dcm_slug', 'dcm_category_id', 'dcm_price', 'dcm_number',
					'dcm_admin_id', 'dcm_view', 'dcm_ext', 'dcm_download', 'dcm_avatar')
					->limit(8)
					->orderByDesc('id')
					->get()->toArray();

				$categories[] = [
					'category'  => $category ?? [],
					'documents' => $document ?? []
				];
			}
		}

		$html = view('pages.home.include._inc_product_by_category_hot', compact('categories'))->render();
		return response()->json(['data' => $html]);
//		}
	}

	public function getComboHot()
	{
		$comboDocuments = ComboDocument::where([
			'cd_hot' => 1
		])
			->orderByDesc('id')
			->select('id','cd_name','cd_avatar','cd_price','cd_slug')
			->limit(8)
			->get();

		$viewData = [
			'customer_style' => 'width:25%;max-width: 25%;',
			'comboDocuments' => $comboDocuments
		];

		$html = view('pages.combo.include._inc_list_combo', $viewData)->render();
		return response()->json(['data' => $html]);
	}

	public function getHotDocument(Request $request)
	{
		if ($request->ajax()) {
			$documents = Document::with('admin:id,name,slug')
				->where([
					'dcm_active' => 1,
					'dcm_hot' => 1
				])
				->select('id', 'dcm_name', 'dcm_slug', 'dcm_admin_id', 'dcm_number', 'dcm_price', 'dcm_view', 'dcm_ext', 'dcm_download', 'dcm_avatar')
				->limit(8)
				->orderBy('id', 'desc')
				->get();

			$viewData = [
				'customer_style' => 'width:25%;max-width: 25%;',
				'documents' => $documents
			];

			$html = view('components.document', $viewData)->render();

			return response()->json(['data' => $html]);
		}
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 * Load event
	 */
	public function getEvent(Request $request)
	{
		if ($request->ajax()) {
			// Lấy event hiển thị đầu
			$event1 = Event::where('e_position_1', 1)
				->first();

			if ($event1)
			{
				$data['event1'] = [
					'name' => $event1->e_name,
					'link' => $event1->e_link,
					'banner' => pare_url_file($event1->e_banner)
				];
			}


			// Lấy event hiển thị 2
			$event2 = Event::where('e_position_2', 1)
				->first();

			if ($event2)
			{
				$data['event2'] = [
					'name' => $event2->e_name,
					'link' => $event2->e_link,
					'banner' => pare_url_file($event2->e_banner)
				];
			}

			// Lấy event hiển thị 3
			$event3 = Event::where('e_position_3', 1)
				->first();

			if ($event3)
			{
				$data['event3'] = [
					'name' => $event3->e_name,
					'link' => $event3->e_link,
					'banner' => pare_url_file($event3->e_banner)
				];
			}

			$commentUser = view('pages.home.include._inc_comment_user')->render();
			$data['comment_user'] = $commentUser;
			return response()->json($data);
		}
	}
}
