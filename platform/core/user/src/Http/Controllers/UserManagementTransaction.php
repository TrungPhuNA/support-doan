<?php

namespace Core\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SystemPay\PayHistory;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;

class UserManagementTransaction extends Controller
{
	public function index()
	{
		$payHistories = PayHistory::where([
			'ph_user_id' => get_data_user('web')
		])->orderByDesc('id')
			->paginate(10);

		$optionsMeta = [
			'meta_title'       => 'Biến động số dư',
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_image'       => '',
			'meta_robots'      => ''
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

		$viewData = [
			'metaSeo'      => $metaSeo,
			'payHistories' => $payHistories
		];

		return view('user::pages.management_transaction', $viewData);
	}
}
