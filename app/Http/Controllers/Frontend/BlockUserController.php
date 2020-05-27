<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;

class BlockUserController extends Controller
{
    public function index()
	{
		$optionsMeta = [
			'meta_title'       => 'Kho tài liệu lớn nhất việt nam',
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_image'       => '',
			'meta_robots'      => ''
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);
		$viewData = [
			'metaSeo' => $metaSeo
		];
		return view('pages.static.block_user', $viewData);
	}
}
