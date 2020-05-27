<?php


namespace Core\Admin\Http\Controllers;


use App\HelpersClass\Date;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\SystemPay\PayIn;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminGetDataAjaxController extends Controller
{
	public function getPayIn(Request $request)
	{
		if ($request->ajax()) {
			$payIns = PayIn::with('admin:id,name', 'user:id,name')
				->orderByDesc('id')
				->limit(10)
				->get();
			$status = (new PayIn())->getStatus();

			$viewData = [
				'status' => $status,
				'payIns' => $payIns
			];

			$view = view('admin::statistical.include._inc_pay_in', $viewData)->render();

			return response()->json(['view' => $view]);
		}
	}

	public function getTopDownload(Request $request)
	{
		if ($request->ajax()) {
			// Top download nhiều
			$topDownloadDocument = Document::where('dcm_active', Document::STATUS_ACTIVE)
				->orderByDesc('dcm_download')
				->select('id', 'dcm_name', 'dcm_slug', 'dcm_download', 'dcm_age_review')
				->limit(10)
				->get();

			$view = view('admin::statistical.include._inc_document_download', compact('topDownloadDocument'))->render();
			return response()->json(['view' => $view]);
		}
	}

	public function getCharDashboard(Request $request)
	{
		if ($request->ajax()) {
			$payInSuccess = PayIn::where('pi_status', PayIn::STATUS_SUCCESS)
				->whereMonth('created_at', date('m'))
				->select(\DB::raw('sum(pi_money) as totalMoney'), \DB::raw('DATE(created_at) day'))
				->groupBy('day')
				->get()->toArray();

			$listDay                    = Date::getListDayInMonth();
			$arrRevenuePayInMonth       = [];
			$arrRevenueTransactionMonth = [];

			$revenueTransactionMonth = Transaction::where('tst_status', 2)
				->whereMonth('created_at', date('m'))
				->select(\DB::raw('count(tst_total_money) as totalMoney'), \DB::raw('DATE(created_at) day'))
				->groupBy('day')
				->get()->toArray();

			foreach ($listDay as $day) {
				$total = 0;
				foreach ($payInSuccess as $key => $revenue) {
					if ($revenue['day'] == $day) {
						$total = $revenue['totalMoney'];
						break;
					}
				}
				$arrRevenuePayInMonth[] = (int)$total;

				$total = 0;
				foreach ($revenueTransactionMonth as $key => $item) {
					if ($item['day'] == $day) {
						$total = $item['totalMoney'];
						break;
					}
				}
				$arrRevenueTransactionMonth[] = (int)$total;
			}

			return response()->json([
				'listDay'                    => json_encode($listDay),
				'arrRevenueTransactionMonth' => json_encode($arrRevenueTransactionMonth),
				'arrRevenuePayInMonth'       => json_encode($arrRevenuePayInMonth),
			]);
		}
	}
}