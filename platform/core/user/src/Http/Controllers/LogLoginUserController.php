<?php

namespace Core\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;

class LogLoginUserController extends Controller
{
	public function index()
	{
		$historyLog = \Auth::user()->log_login;
		$historyLog = json_decode($historyLog, true) ?? [];

		$optionsMeta = [
			'meta_title'       => 'Lịch sử đăng nhập',
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_image'       => '',
			'meta_robots'      => ''
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

		$viewData = [
			'historyLog' => $historyLog,
			'metaSeo'    => $metaSeo
		];
		return view('user::pages.history_login', $viewData);
	}
}
