<?php

namespace App\Console\Commands\Convert;

use App\HelpersClass\AddTextInImage;
use App\Models\Document;
use Illuminate\Console\Command;

class AddTextInImageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:add-text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add text in image';

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
		$this->info('AddTextInImageCommand');
		$documents = Document::select('id','dcm_cdn_image','dcm_cdn_preview')
			->get();

		foreach ($documents as $document)
		{
			if ($document->dcm_cdn_preview) {
				$cdnImages = json_decode($document->dcm_cdn_preview, true);
				foreach ($cdnImages as $image)
				{
					$path = public_path() . '/previews/'. $image;
					AddTextInImage::addTextInImageByPackage($path);
					$this->info("---- ". $image);
				}
			}
		}
    }
}
