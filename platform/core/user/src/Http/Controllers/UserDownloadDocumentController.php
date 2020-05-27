<?php

namespace Core\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Document;
use App\Models\Transaction;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Hashids\Hashids;

class UserDownloadDocumentController extends Controller
{
	protected function getIdTransaction($token)
	{
		$get_token     = config('setting._token');
		$hashids       = new Hashids('', 50, $get_token);
		$transactionID = $hashids->decode($token);
		$transactionID = $transactionID[0] ?? 0;
		return $transactionID;
	}

	public function renderViewDownloadDocument(Request $request)
	{
		$token         = $request->get('_token');
		$transactionID = $this->getIdTransaction($token);

		if ($transactionID) {
			$userId      = \Auth::user()->id;
			$transaction = Transaction::with('document:id,dcm_file,dcm_name,dcm_view,dcm_download,dcm_ext,dcm_admin_id,dcm_number')->where([
				'id'          => $transactionID,
				'tst_user_id' => $userId
			])->first();

			if (!$transaction) {
				return abort(404);
			}

			$admin = Admin::find($transaction->document->dcm_admin_id ?? 0);

			$documentsHot = Document::with('admin:id,name')
				->select('id', 'dcm_name', 'dcm_slug', 'dcm_admin_id', 'dcm_view', 'dcm_ext', 'dcm_download', 'dcm_avatar', 'dcm_number')
				->limit(10)
				->get();

			if ($request->alert) {
				\Session::flash('toastr', [
					'type'    => 'success',
					'message' => 'Mua tài liệu thành công'
				]);
			}

			$optionsMeta = [
				'meta_title'       => 'Download tài liệu',
			];
			$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

			$viewData = [
				'documentsHot' => $documentsHot,
				'admin'        => $admin ?? [],
				'metaSeo'      => $metaSeo,
				'download'	   => $request->download ?? false,
				'transaction'  => $transaction
			];
			return view('pages.document.process_download_document', $viewData);
		}

		return redirect()->to('/');
	}

	public function downloadDocument(Request $request)
	{
		$token         = $request->token;
		$transactionID = $this->getIdTransaction($token);

		if (!$transactionID) {
			return response([
				'code'     => 404,
				'messages' => 'Không tồn tại dữ liệu'
			]);
		}

		$transaction = Transaction::with('document:id,dcm_file,dcm_name,dcm_ext')->where([
			'id'          => $transactionID,
			'tst_user_id' => \Auth::user()->id
		])->first();

		$file_path = pare_url_file($transaction->document->dcm_file);

		return response()->download(public_path($file_path), '[Tailieu247].' . $transaction->document->dcm_name.".".$transaction->document->dcm_ext);
	}
}
