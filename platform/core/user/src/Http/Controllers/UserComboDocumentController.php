<?php

namespace Core\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ComboDocument;
use App\Models\Document;
use App\Models\Transaction;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserComboDocumentController extends Controller
{
	public function renderViewDownloadCombo(Request $request)
	{
		Log::info("[renderViewDownloadCombo]");
		$token         = $request->get('_token');
		$transactionID = $this->getIdTransaction($token);

		if ($transactionID) {
			Log::info(" -- [done]");
			$userId      = \Auth::user()->id;
			$transaction = Transaction::where([
				'id'          => $transactionID,
				'tst_user_id' => $userId
			])->first();

			if (!$transaction) {
				return abort(404);
			}

			$combo = ComboDocument::with('documents')
				->where('id', $transaction->tst_combo_id)
				->first();

			if (!$combo) return abort('404');
			$documents = null;

			if (isset($combo->documents))
				$documents = $combo->documents;

			if ($request->alert) {
				\Session::flash('toastr', [
					'type'    => 'success',
					'message' => 'Mua combo thành công'
				]);
			}

			$documentsDownload = Document::with('admin:id,name')
				->select('id', 'dcm_name', 'dcm_slug', 'dcm_admin_id', 'dcm_number', 'dcm_view', 'dcm_ext', 'dcm_download', 'dcm_avatar')
				->orderBy('dcm_download','desc')
				->limit(10)
				->get();


			$optionsMeta = [
				'meta_title'       => 'Download Combo tài liệu ' .$combo->cd_name,
				'meta_description' => '',
				'meta_keywords'    => '',
				'meta_image'       => '',
				'meta_robots'      => ''
			];
			$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);


			$viewData = [
				'transaction'       => $transaction,
				'documents'         => $documents,
				'combo'             => $combo,
				'metaSeo'		    => $metaSeo,
				'documentsDownload' => $documentsDownload
			];

			return view('pages.document.process_download_combo', $viewData);
		}

		return redirect()->to('/');
	}

	protected function getIdTransaction($token)
	{
		$hashids       = new Hashids('', 50, config('setting._token'));
		$transactionID = $hashids->decode($token);
		$transactionID = $transactionID[0] ?? 0;
		return $transactionID;
	}

	public function downloadItemDocumentCombo(Request $request)
	{
		$param = $request->all();
		//1 nếu ko đủ 3 tham số thì loại
		if (count($param) != 3) return redirect()->to('/');

		//2. check lai token để lấy mã đơn hàng
		$token         = $request->get('token');
		$transactionID = $this->getIdTransaction($token);

		if (!$transactionID) return redirect()->to('/');

		//3. Check mã đơn hàng đc render vs gủi url
		if ($transactionID != $request->transaction) redirect()->to('/');

		//4. kiểm tra đơn hàng có phải của user ko
		$userId      = \Auth::user()->id;
		$transaction = Transaction::where([
			'id'          => $transactionID,
			'tst_user_id' => $userId
		])->first();

		if (!$transaction) return redirect()->to('/');;

		//5. Kiểm tra tài liệu cần download có khớp vs đơn hàng k
		$checkDocumentByCombo = \DB::table('combo_document_multiple')
			->where('cdm_combo_id', $transaction->tst_combo_id)
			->pluck('cdm_document_id')
			->toArray();

		$documentID = $request->document;

		if (!$checkDocumentByCombo || !in_array($documentID, $checkDocumentByCombo)) redirect()->to('/');

		// Sau khi qua cac buoc check ok tien hanh download
		$document  = Document::find($documentID);
		$file_path = pare_url_file($document->dcm_file);
		return response()->download(public_path($file_path), '[Tailieu247].' . $document->dcm_name.'.'.$document->dcm_ext);
	}
}
