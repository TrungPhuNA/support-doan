<?php

namespace Core\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
	protected $userId;

	public function __construct()
	{

	}

	public function getIdUser()
	{
		return \Auth::user()->id;
	}

	public function dashboard()
	{
		$totalTransactionSuccess = Transaction::where([
			'tst_user_id' => $this->getIdUser(),
			'tst_status'  => 2
		])
			->select('id')
			->count();
		$optionsMeta             = [
			'meta_title'       => 'Quản lý tài khoản',
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_image'       => '',
			'meta_robots'      => ''
		];
		$metaSeo                 = RenderMetaSeo::MetaSeo($optionsMeta);

		$viewData = [
			'totalTransactionSuccess' => $totalTransactionSuccess,
			'metaSeo'                 => $metaSeo
		];

		return view('user::pages.dashboard', $viewData);
	}
}
