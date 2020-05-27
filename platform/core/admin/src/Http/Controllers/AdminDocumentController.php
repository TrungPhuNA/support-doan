<?php

namespace Core\Admin\Http\Controllers;

use App\Http\Requests\AdminRequestDocument;
use App\Jobs\ProcessingQueueDocument;
use App\Jobs\ProcessingQueueFilePdfDocument;
use App\Models\Category;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Plugins\ConvertWordPdf\PdfConvertServices;

class AdminDocumentController extends AdminBaseController
{
	public function index(Request $request)
	{
		$documents = Document::with('category:id,c_name');
		if ($cate = $request->category)
			$documents->where('dcm_category_id', $cate);

		if ($id = $request->id)
			$documents->where('id', $id);

		if ($status = $request->status) {
			$status = 2 ? 0 : 1;
			$documents->where('dcm_active', $status);
		}

		if ($name = $request->name)
			$documents->where('dcm_name', "like", '%' . $name . '%');

		$documents = $documents->orderByDesc('id')
			->paginate(10);

		$viewData = [
			'documents'  => $documents,
			'query'      => $request->query(),
			'categories' => $this->getCategoriesSort()
		];
		return view('admin::document.index', $viewData);
	}

	public function create()
	{
		$categories = $this->getCategoriesSort();
		$viewData   = [
			'categories' => $categories
		];

		return view('admin::document.create', $viewData);
	}

	public function store(AdminRequestDocument $request)
	{
		$data                 = $request->except('dcm_avatar', '_token', 'dcm_file');
		$data['dcm_slug']     = Str::slug($request->dcm_name);
		$data['dcm_admin_id'] = get_data_user('admins');
		$data['dcm_price']    = str_replace([',', '.'], '', $request->dcm_price);
		$data['created_at']   = Carbon::now();

		if ($request->dcm_avatar) {
			$image = upload_image('dcm_avatar','uploads_preview');
			if ($image['code'] == 1)
				$data['dcm_avatar'] = $image['name'];
		}
		$data['dcm_active'] = 0;
		if ($request->dcm_file) {
			$image = upload_image('dcm_file','',['doc', 'docx', 'pdf','ppt', 'pptx']);
			if ($image['code'] == 1) {
				$data['dcm_ext']          = $image['ext'];
				$data['dcm_file']         = $image['name'];
				$data['dcm_file_preview'] = $image['name'];
				$data['dcm_size']         = $image['size'];

				$path = public_path(pare_url_file($image['name']));
				if (check_pdf($data['dcm_ext'])) {
					$infoFile                 = (new PdfConvertServices($path))->getInfoFile();
					$data['dcm_number']       = $infoFile['total_page'] ?? 0;
					$data['dcm_file_preview'] = $image['name'];

					$flag_convert_pdf = true;
					if ($request->dcm_link_preview)
					{
						$data['dcm_active'] = Document::STATUS_ACTIVE;
						$flag_convert_pdf = false;
					}

				} else {
					$flag_convert_word = true;
				}
			}
		}

		$document = Document::create($data);
		if ($document) {
			$this->syncAdmin();
			$this->syncIncrementCategory($data['dcm_category_id']);
			$this->getMessagesSuccess();
			if (isset($flag_convert_word)) {
				$this->callProcessQueueDocument($document);
			}

			if (isset($flag_convert_pdf))
			{
				$this->callProcessingQueueFilePdfDocument($document);
			}
		}

		return redirect()->back();
	}

	protected function callProcessQueueDocument($document)
	{
		dispatch(new ProcessingQueueDocument($document))->onQueue('convert-word');
	}

	protected function callProcessingQueueFilePdfDocument($document)
	{
		dispatch(new ProcessingQueueFilePdfDocument($document))->onQueue('cut-move-pdf');
	}

	public function edit($id)
	{
		$categories = $this->getCategoriesSort();
		$document   = Document::find($id);
		$viewData   = [
			'categories' => $categories,
			'document'   => $document
		];
		return view('admin::document.update', $viewData);
	}

	public function update(AdminRequestDocument $request, $id)
	{
		$data              = $request->except('dcm_avatar', '_token', 'dcm_file', 'dcm_file_preview');
		$data['dcm_slug']  = Str::slug($request->dcm_name);
		$data['dcm_price'] = str_replace([',', '.'], '', $request->dcm_price);
		$document          = Document::find($id);

		if ($request->dcm_avatar) {
			$image = upload_image('dcm_avatar','uploads_preview');
			if ($image['code'] == 1)
				$data['dcm_avatar'] = $image['name'];
		}

		if ($request->dcm_file) {
			$image = upload_image('dcm_file', '', ['doc', 'docx', 'pdf','ppt', 'pptx']);
//			dd($image);
			if ($image['code'] == 1) {
				$data['dcm_ext']          = $image['ext'];
				$data['dcm_file']         = $image['name'];
				$data['dcm_size']         = $image['size'];
				$data['dcm_file_preview'] = $image['name'];

				$data['dcm_size'] = $image['size'];

				$path = public_path(pare_url_file($image['name']));
				if (check_pdf($data['dcm_ext'])) {
					$infoFile                 = (new PdfConvertServices($path))->getInfoFile();
					$data['dcm_number']       = $infoFile['total_page'] ?? 0;
					$data['dcm_file_preview'] = $image['name'];
					$flag_convert_pdf = true;

					if ($request->dcm_link_preview)
					{
						$data['dcm_active'] = Document::STATUS_ACTIVE;
						$flag_convert_pdf = false;
					}

				} else {
					$flag_convert_word = true;
				}
			}
		}


		$document->fill($data)->save();

		$this->getMessagesSuccess();
		if ($document->dcm_category_id != $data['dcm_category_id']) {
			$this->syncIncrementCategory($data['dcm_category_id']);
			$this->syncDecrementCategory($document->dcm_category_id);
		}

		if (isset($flag_convert_word)) {
			$this->callProcessQueueDocument($document);
		}

		if (isset($flag_convert_pdf))
		{
			$this->callProcessingQueueFilePdfDocument($document);
		}

		return redirect()->back();
	}

	public function restartConvertFile(Request $request, $id)
	{
		$document = Document::find($id);
		$document->dcm_active = Document::STATUS_DEFAULT;
		$document->save();

		if (check_pdf($document->dcm_ext))
		{
			$this->callProcessingQueueFilePdfDocument($document);
		}else{
			$this->callProcessQueueDocument($document);
		}

		$this->getMessagesSuccess();

		return redirect()->back();
	}

	public function delete($id)
	{
		$document = Document::findOrFail($id);
		if ($document)
		{
			$document->delete();
		}

		return redirect()->route('admin.document.index');
	}

	public function active($id)
	{
		$document             = Document::find($id);
		$document->dcm_active = !$document->dcm_active;
		$document->save();
		$this->getMessagesSuccess();

		return redirect()->back();
	}

	public function hot($id)
	{
		$document          = Document::find($id);
		$document->dcm_hot = !$document->dcm_hot;
		$document->save();

		$this->getMessagesSuccess();

		return redirect()->back();
	}

	protected function syncAdmin()
	{
		\DB::table('admins')->where('id', get_data_user('admins'))
			->increment('count_document');
	}

	protected function syncIncrementCategory($categoryID)
	{
		\DB::table('categories')->where('id', $categoryID)
			->increment('c_count_document');
	}

	protected function syncDecrementCategory($categoryID)
	{
		\DB::table('categories')->where('id', $categoryID)
			->decrement('c_count_document');
	}

	protected function getCategoriesSort()
	{
		$categories = Category::where('c_status', Category::STATUS_ACTIVE)
			->select('id', 'c_parent_id', 'c_name')->get();

		$listCategoriesSort = [];
		Category::recursive($categories, $parent = 0, $level = 1, $listCategoriesSort);
		return $listCategoriesSort;
	}

	public function convertImages($id)
	{
		$document = Document::findOrFail($id);
		if ($document->dcm_cdn_preview) {
			$cdnImages = json_decode($document->dcm_cdn_preview, true);
			if (count($cdnImages))
			{
				$thumbnail = $cdnImages[0] ?? null;
				if ($thumbnail)
				{
					$img = Image::make(public_path('previews/'). $thumbnail);
					$img->fit(400, 440);

					$path = public_path() . '/uploads_preview/' . date('Y/m/d/');

					if (!\File::exists($path))
						@mkdir($path, 0777, true);

					$img->save($path.date('Y-m-d__').$thumbnail,8);
					\DB::table('documents')->where('id', $document->id)
						->update([
							'dcm_avatar' => date('Y-m-d__').$thumbnail
						]);
				}
			}
		}
		$this->getMessagesSuccess();
		return redirect()->back();
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 * Check data document
	 */
	public function getDataResponse($id)
	{
		$document = Document::with('admin','category')->find($id);
		return response()->json($document);
	}

	/**
	 * @param Request $request
	 * Convert tất cả các file lại
	 */
	public function convertAll(Request $request)
	{
		$documents = Document::where('dcm_active',Document::STATUS_DEFAULT)
			->select('id','dcm_ext')->get();
		foreach ($documents as $item)
		{
			sleep(1);
			$document = Document::find($item->id);
			if (check_pdf($item->dcm_ext))
			{
				$this->callProcessingQueueFilePdfDocument($document);
			}else{
				$this->callProcessQueueDocument($document);
			}
		}

		return redirect()->back();
	}
}
