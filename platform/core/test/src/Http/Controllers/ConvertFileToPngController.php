<?php


namespace Core\Test\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Document;
use ConvertApi\ConvertApi;
use FilePreviews\FilePreviews;
use FilePreviews\FilePreviewsClient;
use Illuminate\Http\Request;

class ConvertFileToPngController extends Controller
{
	public function index()
	{
		return view('test::convert.file_to_png');
	}

	public function convertFileToPng(Request $request)
	{
//		$this->filePreview($request);
		$this->callApi($request);
	}

	public function callApi($request)
	{
		$url = $request->url;
		ConvertApi::setApiSecret('ajADWp9e2LEuU65m');

		$result = ConvertApi::convert('png',
			[
				'File' => $url,
				'PageRange' => '1-5',
			]
		);
		$files = $result->getFiles();
		$data = [];
		foreach ($files as $file)
		{
			$data[] = $file->fileInfo;
		}

		Document::where('id', 1)
			->update([
				'dcm_active' => 1,
				'dcm_cdn_image' => json_encode($data)
			]);

		if (!empty($data))
		{
			$list_image = [];
			foreach ($data as $item)
			{
				$url = $item['Url'];
				$path = public_path() . '/previews/';
				$file = md5($item['FileName']).'.png';
				if (!\File::exists($path))
					@mkdir($path, 0777, true);

				saveImageByUrl($url, $path.$file);
				$list_image[] = $file;
			}
			if (!empty($list_image))
			{
				\DB::table('documents')->where('id', 1)
					->update([
						'dcm_cdn_preview' => json_encode($list_image)
					]);
			}

		}
	}

	public function filePreview($request)
	{
		$filepreviews = new \FilePreviews\FilePreviews([
			'api_key' => 'DiZ9VmQFqbi8dLdRnoKhwMEdHQX7QJ',
			'api_secret' => 'PsSI4t9oeS3vSeKyEt02t1KjiqEB9A'
		]);

		$url = $request->url ? $request->url : 'https://tailieu247.net/uploads_preview/392247c7624607d3ab600182a4413592.pdf';

		$options = [
			'size' => [
				'width' => 559,
				'height' => 842
			],
			'format' => 'jpg',
			'pages' => '1',
			'metadata' => ['exif', 'ocr', 'psd'],
			'data' => ['foo' => 'bar']
		];

		$response = $filepreviews->generate($url, $options);
		print_r($response);

		$response = $filepreviews->retrieve($response->id);
		print_r($response);
	}

	public function callbackApi(Request $request, $id)
	{
		\Log::info("[callbackApi]". $id);
	}
}