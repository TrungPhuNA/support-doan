<?php


namespace Core\Test\Http\Controllers;


use App\Jobs\ProcessingQueueDocument;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;

class UploadMultipleDocumentTestController
{
	public function add()
	{
		$categories = $this->getCategoriesSort();
		return view('test::document.add', compact('categories'));
	}

	public function store(Request $request)
	{
		$files = $request->file;
		foreach ($files as $key => $fileImage) {

			try {
				$ext = strtolower($fileImage->getClientOriginalExtension());

				$size = $fileImage->getSize();
				$size = round($size / (1024), 1);

				$extend = [
					'doc', 'pdf', 'docx'
				];

				if (!in_array($ext, $extend)) continue;

				$nameFile           = trim(str_replace('.' . $ext, '', strtolower($fileImage->getClientOriginalName())));
				$filename           = date('Y-m-d__') . \Str::slug($nameFile) . '.' . $ext;
				$path               = public_path() . '/uploads/' . date('Y/m/d/');

				if (!\File::exists($path)) {
					@mkdir($path, 0777, true);
				}

				$fileImage->move($path, $filename);

				$data     = [
					'dcm_active'       => Document::STATUS_DEFAULT,
					'dcm_name'         => $nameFile,
					'dcm_slug'         => \Str::slug($nameFile),
					'dcm_ext'          => $ext,
					'dcm_file'         => $filename,
					'dcm_size'         => $size,
					'dcm_category_id'  => $request->dcm_category_id,
					'dcm_price'        => 12000,
					'dcm_description'  => $filename,
					'dcm_content'      => $filename,
					'dcm_file_preview' => ''
				];
				$document = Document::create($data);
				if ($document) {
					dispatch(new ProcessingQueueDocument($document))->onQueue('convert-word')->delay(10);
				}
			} catch (\Exception $exception) {
				\Log::error("[Error file:]" . $filename . " --- " . $exception->getMessage());
			}
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
}