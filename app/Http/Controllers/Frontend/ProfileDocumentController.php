<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Document;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileDocumentController extends Controller
{
	public function index(Request $request, $slug)
	{
		$slug = explode("-", $slug);
		$slug = array_pop($slug);

		$admin = Admin::where('slug', $slug)->first();
		if (!$admin) return abort('404');

		$documents = Document::with('admin:id,name,slug')
			->where('dcm_admin_id', $admin->id)
			->where('dcm_active', '1')
			->select('id', 'dcm_name', 'dcm_price', 'dcm_slug','dcm_number', 'dcm_admin_id', 'dcm_view', 'dcm_ext', 'dcm_download', 'dcm_avatar')
			->orderByDesc('id')
			->paginate(20);

		$optionsMeta = [
			'meta_title'       => 'Trang cá nhân '. $admin->name,
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_image'       => '',
			'meta_robots'      => ''
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);


		$viewData = [
			'admin'     => $admin,
			'metaSeo'   => $metaSeo,
			'documents' => $documents
		];

		return view('pages.profile.index', $viewData);
	}
}
