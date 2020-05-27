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
use Intervention\Image\Image;

class ProcessingQueueFilePdfDocument implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $document;

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
		Log::info("[init ProcessingQueueFilePdfDocument]");
		$path = $this->document->dcm_file;
		$path = public_path(pare_url_file($path));

		if (!file_exists($path))
		{
			Log::info("----  Cannot file ". $path);
			return;
		}

		$setting = \DB::table('settings_api')->first();
		if (!$setting) return false;

		$dataSetting = json_decode($setting->data, true);
		$apiSecret = $dataSetting['api']['convert_file_api_secret'] ?? null;
		if (!$apiSecret) return false;

		try {
            Log::info("----  convert image pdf ID ". $this->document->id);
			ConvertApi::setApiSecret($apiSecret);
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
			}else {
				Log::error('-- -- Empty file convert pdf to image api');
			}
		} catch (\Exception $exception) {
			Log::error('---- [ProcessingQueueFilePdfDocument]' .$exception->getMessage());
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
		Log::info("-- -- --  init createThumbnailDocument");

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
					$this->info("---- ". date('Y-m-d__').$thumbnail);
				}
			}
		}
	}
}