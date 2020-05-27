<?php

namespace Core\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequestComboDocument;
use App\Jobs\ProcessingQueueDocument;
use App\Jobs\ProcessingQueueFilePdfDocument;
use App\Models\Category;
use App\Models\ComboDocument;
use App\Models\ComboDocumentMultiple;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Plugins\ConvertWordPdf\PdfConvertServices;

class AdminComboDocumentController extends Controller
{
	public function index(Request $request)
	{
		$comboDocuments = ComboDocument::with('documents');

		if ($request->id)
			$comboDocuments->where('id', $request->id);

		if ($request->name)
			$comboDocuments->where('cd_name','like','%'.$request->name.'%');

		$comboDocuments = $comboDocuments
			->orderByDesc('id')
			->paginate(10);

		$viewData = [
			'comboDocuments' => $comboDocuments,
			'query' => $request->query()
		];

		return view('admin::combo_document.index', $viewData);
	}

	public function create()
	{
		$documents = Document::where('dcm_active', 1)
			->select('dcm_name', 'id')
			->get();

		$viewData = [
			'categories'   => $this->getCategoriesSort(),
			'documentsOld' => [],
			'documents'    => $documents
		];

		return view('admin::combo_document.create', $viewData);
	}

	public function store(AdminRequestComboDocument $request)
	{
		$data                = $request->except('_token', 'combo_document',
			'cd_avatar', 'cd_file', 'file', 'dcm_price', 'dcm_category_id');
		$data['cd_slug']     = Str::slug($request->cd_name);
		$data['created_at']  = Carbon::now();
		$data['cd_admin_id'] = get_data_user('admins');
		if ($request->cd_avatar) {
			$image = upload_image('cd_avatar');
			if ($image['code'] == 1)
				$data['cd_avatar'] = $image['name'];
		}
		if ($request->cd_file) {
			$image = upload_image('cd_file', '', ['raw', 'zip','rar']);
			if ($image['code'] == 1)
				$data['cd_file'] = $image['name'];
		}

		$id = ComboDocument::insertGetId($data);
		if ($id) {
			if ($request->combo_document) {
				$documents = $request->combo_document;
				$this->syncComboDocument($documents, $id);
			}
			if ($request->file)
				$this->uploadMultipleDocument($request->file, $id, $request->dcm_category_id, $request->dcm_price, $request->cd_content);
		}

		return redirect()->back();
	}

	protected function uploadMultipleDocument($files, $comboID, $categoryID, $price, $content)
	{
		foreach ($files as $key => $fileImage) {

			try {
				$ext = strtolower($fileImage->getClientOriginalExtension());

				$size = $fileImage->getSize();
				$size = round($size / (1024), 1);

				$extend = [
					'doc', 'pdf', 'docx', 'pptx','ppt'
				];

				if (!in_array($ext, $extend)) continue;

				$nameFile = trim(str_replace('.' . $ext, '', strtolower($fileImage->getClientOriginalName())));
				$filename = date('Y-m-d__') . \Str::slug($nameFile) . '.' . $ext;
				$path     = public_path() . '/uploads/' . date('Y/m/d/');

				if (!\File::exists($path)) {
					@mkdir($path, 0777, true);
				}

				$fileImage->move($path, $filename);

				$data     = [
					'dcm_active'       => Document::STATUS_DEFAULT,
					'dcm_name'         => mb_strtolower($nameFile),
					'dcm_slug'         => \Str::slug($nameFile),
					'dcm_ext'          => $ext,
					'dcm_file'         => $filename,
					'dcm_size'         => $size,
					'dcm_category_id'  => $categoryID,
					'dcm_price'        => str_replace([',', '.'], '', $price),
					'dcm_description'  => $filename,
					'dcm_content'      => $content,
					'dcm_admin_id'     => get_data_user('admins'),
					'dcm_file_preview' => '',
					'created_at'       => Carbon::now()
				];


				$document = Document::create($data);
				if ($document) {
					\DB::table('combo_document_multiple')->insert([
						'cdm_document_id' => $document->id,
						'cdm_combo_id'    => $comboID
					]);

					if ($categoryID)
					{
						\DB::table('categories')->where('id', $categoryID)
							->increment('c_count_document');
					}

					\DB::table('admins')->where('id', get_data_user('admins'))
						->increment('count_document');

					if(check_pdf($ext))
					{
						$infoFile                 = (new PdfConvertServices(public_path(pare_url_file($filename))))->getInfoFile();
						$number       = $infoFile['total_page'] ?? 0;
						$document->dcm_number = $number;
						$document->save();

						\Log::info("callProcessingQueueFilePdfDocument");
						dispatch(new ProcessingQueueFilePdfDocument($document))->onQueue('cut-move-pdf');
					}else{
						dispatch(new ProcessingQueueDocument($document))->onQueue('convert-word')->delay(10);
					}

				}
			} catch (\Exception $exception) {
				\Log::error("[Error file:]" . $filename . " --- " . $exception->getMessage());
			}
		}
	}

	protected function syncComboDocument($documents, $comboID)
	{
		if (!empty($documents)) {

			foreach ($documents as $key => $document) {
				$data = [
					'cdm_document_id' => $document,
					'cdm_combo_id'    => $comboID
				];

				$check = ComboDocumentMultiple::where([
					'cdm_document_id' => $document,
					'cdm_combo_id' => $comboID
				])->first();
				if (!$check)
				{
					try{
						\DB::table('combo_document_multiple')->insert($data);
					}catch (\Exception $exception){

					}
				}
			}
		}
	}

	public function edit($id)
	{
		$comboDocument = ComboDocument::find($id);
		$documents     = Document::where('dcm_active', 1)
			->select('dcm_name', 'id')
			->get();

		$documentsOld = \DB::table('combo_document_multiple')
			->where('cdm_combo_id', $id)
			->pluck('cdm_document_id')
			->toArray();

		if (!$documentsOld) $documentsOld = [];

		$viewData = [
			'comboDocument' => $comboDocument,
			'documents'     => $documents,
			'categories'    => $this->getCategoriesSort(),
			'documentsOld'  => $documentsOld
		];
		return view('admin::combo_document.create', $viewData);
	}

	public function update(AdminRequestComboDocument $request, $id)
	{
		try {
			$data               = $request->except('_token', 'combo_document',
				'cd_avatar', 'cd_file', 'file', 'dcm_price', 'dcm_category_id');
			$data['cd_slug']    = Str::slug($request->cd_name);
			$data['created_at'] = Carbon::now();

			$comboDocument = ComboDocument::find($id);
			if ($request->cd_avatar) {
				$image = upload_image('cd_avatar');
				if ($image['code'] == 1)
					$data['cd_avatar'] = $image['name'];
			}


			if ($request->cd_file) {
				$image = upload_image('cd_file', '', ['raw', 'zip','rar']);
				if ($image['code'] == 1)
					$data['cd_file'] = $image['name'];
			}

			$comboDocument->fill($data)->save();
			if ($request->combo_document) {
				$documents = $request->combo_document;
				\Log::info("[update syncComboDocument combo_document]");
				$this->syncComboDocument($documents, $id);
			}

			if ($request->file)
			{
				$this->uploadMultipleDocument($request->file, $id, $request->dcm_category_id, $request->dcm_price, $request->cd_content);
				\Log::info("[update multiple document]");
			}

		} catch (\Exception $e) {
			\Log::error("[Update combo] " . $e->getMessage());
		}

		return redirect()->back();
	}

	protected function getCategoriesSort()
	{
		$categories = Category::where('c_status', Category::STATUS_ACTIVE)
			->select('id', 'c_parent_id', 'c_name')->get();

		$listCategoriesSort = [];
		Category::recursive($categories, $parent = 0, $level = 1, $listCategoriesSort);
		return $listCategoriesSort;
	}

	public function hot($id)
	{
		$combo = ComboDocument::findOrFail($id);
		$combo->cd_hot = !$combo->cd_hot;
		$combo->save();

		return redirect()->back();
	}

	public function getDataResponse($id)
	{
		$combo = ComboDocument::with('admin','documents')->find($id);
		return response()->json($combo);
	}

	public function delete($id)
	{
		$combo = ComboDocument::find($id);
		if ($combo){
			\DB::table('combo_document_multiple')
				->where([
					'cdm_combo_id' => $id
				])->delete();

			$combo->delete();
		}

		return redirect()->back();
	}
}
