<?php

namespace App\Jobs;

use App\HelpersClass\AddTextInImage;
use App\Models\Document;
use ConvertApi\ConvertApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Plugins\ConvertWordPdf\PdfConvertServices;
use Plugins\ConvertWordPdf\WordConvertServices;

class ProcessingQueueDocument  implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $document;
	protected $path_file;
	protected $file_ext;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Document $document)
	{
		$this->document = $document;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		set_time_limit(30);
		Log::info("[Convert Wrod to Pdf]");
		$this->path_file = $this->document->dcm_file;
		$this->file_ext  = $this->document->dcm_ext;

		$path = public_path(pare_url_file($this->path_file));

		try{
			Log::info("---- 1. unoconv -f pdf   {$path}");
			exec("unoconv -f pdf  {$path}");

			$this->syncInfoWordToPdf();
		}catch (\Exception $exception)
		{
			Log::error("---- [Error command]". "unoconv -f pdf {$path}" . $exception->getMessage());
		}
	}

	public function syncInfoWordToPdf()
	{
		$name = explode('.',$this->path_file);
		if (isset($name[0]))
		{
			$filename = $name[0].'.pdf';
		}
		$file_pdf = public_path(pare_url_file($filename ?? ""));
		if (!file_exists($file_pdf))
		{
			Log::warning("---- [ID] ".$this->document->id." [404]: ". $file_pdf);
			return false;
		}

		try {
			$infoFile = (new PdfConvertServices($file_pdf))->getInfoFile();
			$number   = $infoFile['total_page'] ?? 0;
			if ($number)
			{
				Document::where('id', $this->document->id)
					->update([
						'dcm_number' => $number,
						'dcm_file_preview' => $filename
					]);

				if (!$this->document->dcm_link_preview)
					$this->convertFileToPng($this->document->dcm_file);
			}
		} catch (\Exception $e) {
			Log::error('---- [syncInfoWordToPdf]' .$e->getMessage());
		}
	}

	protected function convertFileToPng($file)
	{
        Log::info('-- -- -- [convertFileToPng]');
		$setting = \DB::table('settings_api')->first();
		if (!$setting) return false;

		$dataSetting = json_decode($setting->data, true);
		$apiSecret = $dataSetting['api']['convert_file_api_secret'] ?? null;
		if (!$apiSecret) return false;

		try{
			ConvertApi::setApiSecret($apiSecret);
			$path = public_path(pare_url_file($file));
			$result = ConvertApi::convert('png',
				[
					'File' => $path,
					'PageRange' => '1-5',
				]
			);
			$files = $result->getFiles();
			$data = [];
			foreach ($files as $file)
			{
				$data[] = $file->fileInfo;
			}

			if (!empty($data))
			{
				Document::where('id', $this->document->id)
					->update([
						'dcm_cdn_image' => json_encode($data)
					]);


				$list_image = [];
				foreach ($data as $item)
				{
					$url = $item['Url'];
					$path = public_path() . '/previews/';
					$file = md5($item['FileName']).'.jpeg';
					if (!\File::exists($path))
						@mkdir($path, 0777, true);

					saveImageByUrl($url, $path.$file);
					$list_image[] = $file;
				}
				if (!empty($list_image))
				{
					\DB::table('documents')->where('id', $this->document->id)
						->update([
							'dcm_cdn_preview' => json_encode($list_image)
						]);

					$this->addTextInImage($list_image);
					$this->createThumbnailDocument($this->document->id);
				}

			}

		}catch (\Exception $e)
		{
			Log::error('---- [convertFileToPng]' .$e->getMessage());
		}
	}

	public function addTextInImage($images)
	{
		foreach ($images as $item)
		{
			$path = public_path() . '/previews/'.$item;
			AddTextInImage::addTextInImageByPackage($path);
		}
	}

	public function createThumbnailDocument($documentId)
	{
		Log::info("-- -- -- -- init createThumbnailDocument");
		$document = Document::findOrFail($documentId);
		if ($document->dcm_cdn_preview) {
			$cdnImages = json_decode($document->dcm_cdn_preview, true);
			if (count($cdnImages))
			{
				$thumbnail = $cdnImages[0] ?? null;
				if ($thumbnail)
				{
					$img = Image::make(public_path('previews/'). $thumbnail);
					$img->fit(304, 330);

					$path = public_path() . '/uploads_preview/' . date('Y/m/d/');

					if (!\File::exists($path))
						@mkdir($path, 0777, true);

					$img->save($path.date('Y-m-d__').$thumbnail,8);
					\DB::table('documents')->where('id', $document->id)
						->update([
							'dcm_active' => 1,
							'dcm_avatar' => date('Y-m-d__').$thumbnail
						]);
					Log::info("---- ". date('Y-m-d__').$thumbnail);
				}
			}
		}
	}
}
