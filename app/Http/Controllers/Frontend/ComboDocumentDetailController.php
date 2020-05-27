<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ComboDocument;
use App\Models\Transaction;
use App\Services\ProcessViewService;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;

class ComboDocumentDetailController extends Controller
{
	/**
	 * @param Request $request
	 * @param $slug
	 * Chi tiết combo
	 */
	public function comboDetail(Request $request, $slug)
	{
		$slug      = str_replace('.html', '', $slug);
		$arraySlug = explode('-', $slug);
		$id        = array_pop($arraySlug);

		$combo = ComboDocument::with('documents', 'admin:id,name,avatar')
			->where('id', $id)
			->first();

		if (!$combo) return abort('404');
		//2. Xử lý view
		ProcessViewService::view('combo_documents', 'cd_view', 'combo_documents', $id);

		$documents = null;

		if (isset($combo->documents))
			$documents = $combo->documents;

		//3. Check tài liệu đã mua
		$transaction = $this->checkBuyComboDocument($id);

		$optionsMeta = [
			'meta_title'  => $combo->cd_name,
			'meta_robots' => 'INDEX, FOLLOW',
			'meta_image'  => $combo->cd_avatar ? pare_url_file($combo->cd_avatar) : '',
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

		if (get_data_user('web')) {
			$arrDocumentID = $this->getDocumentBuyByUser();
		}


		$viewData = [
			'combo'         => $combo,
			'metaSeo'       => $metaSeo,
			'transaction'   => $transaction,
			'documents'     => $documents,
			'arrDocumentID' => $arrDocumentID ?? []
		];

		return view('pages.combo_detail.index', $viewData);
	}

	/**
	 * @param $comboID
	 * @return bool
	 * check xem combo này đã đươc mua chưa
	 */
	public function checkBuyComboDocument($comboID)
	{
		$userID = get_data_user('web');
		if (!$userID) return false;

		$transaction = Transaction::where([
			'tst_combo_id' => $comboID,
			'tst_user_id'  => $userID
		])->first();

		return $transaction;
	}

	protected function getDocumentBuyByUser()
	{
		$arrDocumentID = \DB::table('transactions')
			->where('tst_user_id', get_data_user('web'))
			->pluck('tst_document_id')
			->toArray();

		return $arrDocumentID;
	}
}
