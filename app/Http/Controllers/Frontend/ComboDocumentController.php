<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ComboDocument;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;

class ComboDocumentController extends FrontendController
{
	/**
	 * @param Request $request
	 * @return
	 * Danh sách combo
	 */
	public function index(Request $request)
	{
		$comboDocuments = ComboDocument::orderByDesc('id')
			->orderByDesc('id')
			->simplePaginate(30);

		$optionsMeta = [
			'meta_title'       => 'Tổng hợp các combo tài liệu giá rẻ nhất hiện nay',
			'meta_description' => 'Combo tất cả các đề thi có đáp án chi tiết, đầy đủ của tất cả các năm',
			'meta_robots'      => 'INDEX, FOLLOW',
		];

		$metaSeo = RenderMetaSeo::MetaSeo($optionsMeta);

		$viewData = [
			'comboDocuments' => $comboDocuments,
			'metaSeo'        => $metaSeo
		];

		return view('pages.combo.index', $viewData);
	}
}
