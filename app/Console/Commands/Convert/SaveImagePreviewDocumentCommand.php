<?php

namespace App\Console\Commands\Convert;

use App\Models\Document;
use Illuminate\Console\Command;

class SaveImagePreviewDocumentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:save-image-preview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save Image Preview';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('SaveImagePreviewDocumentCommand');
        $documents = Document::select('id','dcm_cdn_image','dcm_cdn_preview')
			->get();

        foreach ($documents as $document)
		{
			if ($document->dcm_cdn_image)
			{
				$cdnImages = json_decode($document->dcm_cdn_image, true);
				$data = [];
				foreach ($cdnImages as $item)
				{
					$url = $item['Url'];
					$this->warn("---- ".$url);
					$path = public_path() . '/previews/';
					$file = md5($item['FileName']).'.png';
					if (!\File::exists($path))
						@mkdir($path, 0777, true);
					$this->saveImageByUrl($url, $path.$file);
					$data[] = $file;
				}
				if (!empty($data))
				{
					\DB::table('documents')->where('id', $document->id)
						->update([
							'dcm_cdn_preview' => json_encode($data)
						]);
				}
			}
			//dcm_cdn_preview
		}
    }

    protected function saveImageByUrl($url, $path)
	{
		$this->warn("---- ". $path);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$file_content = curl_exec($ch);
		curl_close($ch);

		$downloaded_file = fopen($path, 'w');
		fwrite($downloaded_file, $file_content);
		fclose($downloaded_file);
	}
}
