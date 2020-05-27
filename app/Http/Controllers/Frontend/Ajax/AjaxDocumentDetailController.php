<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ComboDocument;
use App\Models\Document;
use App\Models\Rating;
use Illuminate\Http\Request;
use Plugins\Rating\Traits\TraitBaseRating;
use Plugins\Rating\Traits\TraitDashboardRating;

class AjaxDocumentDetailController extends Controller
{
	use TraitBaseRating, TraitDashboardRating;

	/**
	 * Load đánh giá
	 * */
	public function getDataAfterRatings(Request $request, $documentID)
	{
		if ($request->ajax()) {

			$document = Document::find($documentID);
			$ratings  = Rating::with('user:id,name')
				->where('r_document_id', $documentID)
				->orderByDesc('id')
				->paginate(10);

			$ratingsDashboard = $this->getDashboardRatingById($documentID);
			$ratingDefault    = $this->mapRatingDefault();

			foreach ($ratingsDashboard as $key => $item) {
				$ratingDefault[$item['r_number']] = $item;
			}

			$viewData = [
				'ratingsDashboard' => $ratingsDashboard,
				'ratingDefault'    => $ratingDefault,
				'ratings'          => $ratings,
				'document'         => $document
			];

			$view = view('pages.document_detail.include._inc_ratings', $viewData)->render();

			return response()->json(['html' => $view]);
		};
	}

	/**
	 * Load combo nếu có và tài liệu kèm theo
	 */
	public function getDataAfter(Request $request)
	{
		if ($request->ajax()) {
			$document = Document::find($request->documentID);
			$category = Category::find($request->categoryID);
			if ($document && $category) {
				$documentSuggest = view('components.document', [
					'documents'      => $this->getDocumentSuggests($category),
					'customer_style' => 'width: 25%;max-width: 25%;'
				])->render();


				// lấy combo
				$list_combo_id = $this->getComboSuggestByDocumentId($document->id) ?? [];
				if (!empty($list_combo_id)) {
					$comboDocuments = ComboDocument::whereIn('id', $list_combo_id)
						->orderByDesc('id')
						->select('id', 'cd_name', 'cd_slug', 'cd_view', 'cd_download')
						->limit(10)
						->get();

					$comboView = view('pages.document_detail.include._inc_combo', [
						'comboDocuments' => $comboDocuments,
					])->render();
				}

				return response()->json([
					'combo_wiew' => $comboView ?? [],
					'document'   => $documentSuggest
				]);
			}
		}
	}

	private function getDocumentSuggests($categoryID)
	{
		$products = Document::with('admin:id,name,slug')
			->where('dcm_category_id', $categoryID)
			->where('dcm_active', '1')
			->select('id', 'dcm_name', 'dcm_slug', 'dcm_admin_id', 'dcm_number', 'dcm_view', 'dcm_ext', 'dcm_download', 'dcm_avatar')
			->limit(8)
			->get();

		return $products;
	}

	public function getComboSuggestByDocumentId($documentId)
	{
		$list_id_combo = \DB::table('combo_document_multiple')
			->where('cdm_document_id', $documentId)
			->pluck('cdm_combo_id')->toArray();

		return $list_id_combo;
	}
}
