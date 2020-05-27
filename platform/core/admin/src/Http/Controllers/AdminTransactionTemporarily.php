<?php


namespace Core\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionTemporarily;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminTransactionTemporarily extends AdminBaseController
{
	public function index(Request $request)
	{
		$transactionTemporarily = TransactionTemporarily::with('document:id,dcm_name,dcm_price,dcm_slug', 'combo:id,cd_name,cd_slug,cd_price');
		if ($request->phone)
			$transactionTemporarily->where('tt_phone', 'like', '%' . $request->phone . '%');

		$transactionTemporarily = $transactionTemporarily
			->orderByDesc('id')
			->paginate(10);

		$viewData = [
			'transactionTemporarily' => $transactionTemporarily,
			'query'                  => $request->query()
		];

		return view('admin::transaction_temporarily.index', $viewData);
	}

	public function delete($id)
	{
		$transaction = TransactionTemporarily::find($id);
		if ($transaction && $transaction->tt_status != TransactionTemporarily::STATUS_SUCCESS) {
			$this->getMessagesSuccess();
			$transaction->delete();
		}

		return redirect()->back();
	}

	public function cancel($id)
	{
		$transaction = TransactionTemporarily::find($id);
		if ($transaction && $transaction->tt_status <= TransactionTemporarily::STATUS_DEFAULT) {
			$this->getMessagesSuccess();
			$transaction->tt_status = TransactionTemporarily::STATUS_CANCEL;
			$transaction->save();
		}

		return redirect()->back();
	}

	public function success($id)
	{
		$transaction = TransactionTemporarily::with('document:id,dcm_name,dcm_price,dcm_slug', 'combo:id,cd_name,cd_slug,cd_price')->find($id);
		if ($transaction && $transaction->tt_status == TransactionTemporarily::STATUS_DEFAULT) {

			if ($transaction->tt_type == 1) {
				$price = $transaction->document->dcm_price;
			} else {
				$price = $transaction->combo->cd_price;
			}
			$idTransaction                  = Transaction::insertGetId([
				'tst_total_money' => $price,
				'tst_phone'       => $transaction->tt_phone,
				'tst_document_id' => $transaction->tt_type == 1 ? $transaction->tt_data_id : 0,
				'tst_combo_id'    => $transaction->tt_type == 2 ? $transaction->tt_data_id : 0,
				'created_at'      => Carbon::now()
			]);
			$transaction->tt_status         = TransactionTemporarily::STATUS_SUCCESS;
			$transaction->tt_transaction_id = $idTransaction;
			$transaction->tt_admin_id       = get_data_user('admins');
			$transaction->save();
		}

		return redirect()->back();
	}
}