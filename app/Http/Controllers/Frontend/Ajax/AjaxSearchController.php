<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ComboDocument;
use App\Models\Document;
use Illuminate\Http\Request;

class AjaxSearchController extends Controller
{
	public function searchDocumentAndCombo(Request $request)
	{
		$value =  $request->value;
		$documents = Document::where('dcm_active', '1')
			->where('dcm_name','like','%'.$value.'%')
			->select('id','dcm_name','dcm_slug','dcm_ext')
			->orderByDesc('id')
			->limit(20)->get();

		$results = [];
		foreach ($documents as $document)
		{
			$results[] = [
				'name'  => $document->dcm_name,
				'img' => strpos($document->dcm_ext,'doc') !== false ? asset('images/icon/word.png') :
					asset('images/icon/pdf.png'),
				'link'  => route('get.document.detail', $document->dcm_slug.'-'. $document->id)
			];
		}
		return response()->json($results);
	}

	public function searchComboDocument(Request $request)
	{
		$value =  $request->value;
		$combos = ComboDocument::where('cd_status', '1')
			->where('cd_name','like','%'.$value.'%')
			->select('id','cd_name','cd_slug')
			->orderByDesc('id')
			->limit(20)->get();

		$results = [];
		foreach ($combos as $item)
		{
			$results[] = [
				'name'  => $item->cd_name,
				'link'  => route('get.combo_document.detail',$item->cd_slug.'-'.$item->id)
			];
		}
		return response()->json($results);
	}
}
