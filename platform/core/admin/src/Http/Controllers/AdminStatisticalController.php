<?php

namespace Core\Admin\Http\Controllers;

use App\HelpersClass\Date;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\SystemPay\PayIn;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminStatisticalController extends Controller
{
	public function index()
	{
		//Tổng hđơn hàng
		$totalTransactions = \DB::table('transactions')->select('id')->count();

		//Tổng thành viên
		$totalUsers = \DB::table('users')->select('id')->count();

		// Tông sản phẩm
		$totalDocuments = \DB::table('documents')->select('id')->count();

		// Tổng tiền từ bảng đơn hàng
		$totalMoneyTransactions = \DB::table('transactions')
			->where('tst_status', 2)
			->sum('tst_total_money');

		// Tổng lượt tải từ tài liệu
		$totalDownloadDocument      = \DB::table('documents')->sum('dcm_download');
		$totalDownloadComboDocument = \DB::table('combo_documents')->sum('cd_download');
		$totalDownload              = $totalDownloadDocument + $totalDownloadComboDocument;


		$statisticalPayIn =  PayIn::where('pi_status', PayIn::STATUS_SUCCESS)
			->select(
				DB::raw('YEAR(created_at) as year'),
				DB::raw('MONTH(created_at) as month'),
				DB::raw('SUM(pi_money) as money')
			)
			->groupBy('month','year')
			->orderBy('year','ASC')
			->orderBy('month','ASC')
			->get();

		$viewData = [
			'totalTransactions'      => $totalTransactions,
			'totalUsers'             => $totalUsers,
			'statisticalPayIn'	     => $statisticalPayIn,
			'totalDocuments'         => $totalDocuments,
			'totalMoneyTransactions' => $totalMoneyTransactions,
			'totalDownload'          => $totalDownload
		];

		return view('admin::statistical.index', $viewData);
	}
}
