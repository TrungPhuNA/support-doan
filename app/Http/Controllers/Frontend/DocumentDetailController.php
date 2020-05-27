<?php

namespace App\Http\Controllers\Frontend;

use App\HelpersClass\ReadWord;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ComboDocument;
use App\Models\Document;
use App\Models\Rating;
use App\Models\Transaction;
use App\Services\ProcessViewService;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Comment\Doc;
use Plugins\ConvertWordPdf\PdfConvertServices;

class DocumentDetailController extends FrontendController
{
	/**
	 * @param Request $request
	 * @param $slug
	 * Chi tiết tài liệu
	 */
	public function getDocumentDetail(Request $request, $slug)
	{
		$slug      = str_replace('.html', '', $slug);
		$arraySlug = explode('-', $slug);
		$id        = array_pop($arraySlug);

		if ($id) {
			$document = Document::with('admin:id,name,avatar,count_document,slug', 'category:id,c_name,c_slug')
				->where('dcm_active', '1')
				->find($id);
			if (!$document) return abort('404');

			//2. Xử lý view
			ProcessViewService::view('documents', 'dcm_view', 'documents', $id);

			$transaction = $this->checkBuyComboDocument($id);

			if ($document->dcm_cdn_preview) {
				$cdnImages = json_decode($document->dcm_cdn_preview, true);
			}

			//. Lấy category
			$category = Category::find($document->dcm_category_id);
			if ($category) {
				$allParentCategory = json_decode($category->c_all_parent, true);
				if (!empty($allParentCategory)) {
					$multipleCategory = Category::whereIn('id', $allParentCategory)->select('id', 'c_name', 'c_slug')->get();
				}
			}

			// Xử lý rel_id

			$optionsMeta = [
				'meta_title'       => $document->dcm_name,
				'meta_description' => $document->dcm_document,
				'meta_image'       => $document->dcm_avatar ? pare_url_file($document->dcm_avatar, 'uploads_preview') : '',
				'meta_robots'      => 'INDEX, FOLLOW',
			];
			$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

			$viewData = [
				'title_page'       => $document->dcm_name,
				'document'         => $document,
				'transaction'      => $transaction,
				'multipleCategory' => $multipleCategory ?? [],
				'metaSeo'          => $metaSeo,
				'cdnImages'        => $cdnImages ?? [],
				'ref_id'           => (int)$request->ref_id ?? null,
				'topViewDocuments' => $this->getProductTopDownload()
			];

			return view('pages.document_detail.index', $viewData);
		}

		return redirect()->to('/');
	}

	private function getProductTopDownload()
	{
		$products = Document::with('admin:id,name')
			->select('id', 'dcm_name', 'dcm_slug', 'dcm_admin_id', 'dcm_number', 'dcm_view', 'dcm_ext', 'dcm_download', 'dcm_avatar')
			->limit(8)
			->orderBy('dcm_download', 'desc')
			->get();

		return $products;
	}

	/**
	 * @param $documentId
	 * @return bool
	 * Check xem đã mua tài liệu này chưa
	 */
	public function checkBuyComboDocument($documentId)
	{
		$userID = get_data_user('web');
		if (!$userID) return false;

		$transaction = Transaction::where([
			'tst_document_id' => $documentId,
			'tst_user_id'     => $userID
		])->first();

		return $transaction;
	}
}
