<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
	public function notfound()
	{
		$optionsMeta = [
			'meta_title'       => '404',
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_image'       => '',
			'meta_robots'      => ''
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);
		$viewData = [
			'metaSeo' => $metaSeo
		];
		return view('errors.404', $viewData);
	}

	public function fatal()
	{
		return view('errors.500');
	}
}
