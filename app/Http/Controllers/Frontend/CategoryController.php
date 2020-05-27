<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Document;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends FrontendController
{
	public function index(Request $request, $slug)
	{
		$slug      = str_replace('.html', '', $slug);
		$arraySlug = explode('-', $slug);
		$id        = array_pop($arraySlug);

		if ($id) {

			$category = Category::find($id);
			if (!$category) return abort('404');

			$subcategory = Category::where('c_parent_id', $id)
				->select('c_name', 'c_slug', 'c_count_document', 'id')
				->get();

			$allParentCategory = json_decode($category->c_all_parent, true) ?? [];

			if (!empty($allParentCategory)) {
				$multipleCategory = Category::whereIn('id', $allParentCategory)->select('id', 'c_name', 'c_slug')->get();
			}

			$arr_all_child = json_decode($category->c_all_child, true) ?? [];

			$documents = Document::with('admin:id,name,slug')
				->where([
					'dcm_active' => 1,
				])
				->whereIn('dcm_category_id', $arr_all_child);

			if ($ext = $request->ext)
				$documents->where('dcm_ext', $ext);

			if ($price = $request->price) {
				$dk = $price == 1 ? ">" : "=";
				$documents->where('dcm_price', $dk, 0);
			}

			if ($type = $request->type) {
				switch ($type) {
					case 1:
						$documents->orderBy('dcm_download', 'DESC');
						break;
					case 2:
						$documents->orderBy('dcm_view', 'DESC');
						break;
					case 3:
						$documents->where('dcm_hot', Document::HOT);
						break;
				}
			}


			$documents = $documents->orderBy('id', $request->sort ?? 'desc')
				->select('id', 'dcm_name', 'dcm_slug', 'dcm_number',
					'dcm_admin_id', 'dcm_view', 'dcm_ext', 'dcm_download', 'dcm_avatar', 'dcm_price')
				->paginate(20);

			$optionsMeta = [
				'meta_title'       => $category->c_name,
				'meta_description' => $category->c_name,
				'meta_robots'      => 'INDEX, FOLLOW',
			];
			$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

			$viewData = [
				'title_page'       => $category->c_name,
				'documents'        => $documents,
				'category'         => $category,
				'multipleCategory' => $multipleCategory ?? [],
				'subcategory'      => $subcategory,
				'metaSeo'          => $metaSeo,
				'query'            => $request->query()
			];

			return view('pages.document.index', $viewData);
		}
	}
}
