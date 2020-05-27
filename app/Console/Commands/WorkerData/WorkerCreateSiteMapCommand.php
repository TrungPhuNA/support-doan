<?php

namespace App\Console\Commands\WorkerData;

use App\Models\Category;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Console\Command;

class WorkerCreateSiteMapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crontab create sitemap to command';

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
    	\Log::info("init create sitemap");
        $this->info("init sitemap");
		$sitemap = \App::make('sitemap');

		//Home
		$sitemap->add(\URL::to('/'), Carbon::now(), 1, 'daily');

		// Category
		$categories = Category::where('c_status', Category::STATUS_ACTIVE)
			->select('id', 'c_parent_id', 'c_name', 'c_all_parent', 'c_slug', 'c_is_parent','updated_at')->get();

		foreach ($categories as $category)
		{
			$this->warn("-- -- ". $category->c_name);
			$sitemap->add(route('get.category.list', $category->c_slug.'-'.$category->id), $category->updated_at, 1, 'daily');
		}

		//Document
		$documents = Document::where('dcm_active', '1')
			->select('id', 'dcm_name', 'dcm_slug', 'updated_at')
			->get();

		foreach ($documents as $document){
			$this->info("-- Document");
			$this->warn("-- -- ". $document->dcm_name);
			$sitemap->add(route('get.document.detail', $document->dcm_slug.'-'. $document->id), $document->updated_at, 1, 'daily');
		}

		// lưu file và phân quyền
		$sitemap->store('xml', 'sitemap');
		if (\File::exists(public_path('sitemap.xml'))) {
			@chmod(public_path('sitemap.xml'), 0777);
		}
    }
}
