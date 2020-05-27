<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class SearchDocumentController extends Controller
{
	public function search(Request $request)
	{
		if ($k = $request->k) {
			$documents = Document::with('admin:id,name,slug')
				->where([
					'dcm_active' => 1
				]);

			$documents->where('dcm_name', 'like', '%' . $k . '%');
			if ($ext = $request->ext)
				$documents->where('dcm_ext', $ext);

			if ($price = $request->price)
			{
				$dk = $price == 1 ? ">" : "=";
				$documents->where('dcm_price',$dk, 0);
			}

			if ($type = $request->type)
			{
				switch ($type)
				{
					case 1:
						$documents->orderBy('dcm_download','DESC');
						break;
					case 2:
						$documents->orderBy('dcm_view','DESC');
						break;
					case 3:
						$documents->where('dcm_hot',Document::HOT);
						break;
				}
			}

			$documents = $documents->select('id', 'dcm_name', 'dcm_slug', 'dcm_number',
				'dcm_admin_id', 'dcm_view', 'dcm_ext', 'dcm_download', 'dcm_avatar')
				->paginate(20);

			$viewData = [
				'title_page' => "Tìm kiếm tài liệu",
				'documents'  => $documents,
				'search'     => true,
				'query'      => $request->query()
			];

			return view('pages.document.index', $viewData);
		}

		return redirect()->back();
	}
}
