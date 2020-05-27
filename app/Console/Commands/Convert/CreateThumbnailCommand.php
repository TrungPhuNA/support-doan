<?php

namespace App\Console\Commands\Convert;

use App\HelpersClass\AddTextInImage;
use App\Models\Document;
use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;

class CreateThumbnailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:thumbnail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create thumbnail';

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
		$documents = Document::where('id','>=',529)
			->select('id','dcm_cdn_image','dcm_cdn_preview')
			->get();

		foreach ($documents as $document)
		{
			$this->info("[-- ID]". $document->id);
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
						$this->info("---- ". date('Y-m-d__').$thumbnail);
					}
				}
			}
		}
    }
}
