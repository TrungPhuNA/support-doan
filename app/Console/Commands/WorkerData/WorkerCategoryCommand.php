<?php

namespace App\Console\Commands\WorkerData;

use App\HelpersClass\DetectCategory;
use App\Models\Category;
use Illuminate\Console\Command;

class WorkerCategoryCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'worker:category-sync-data
    						{--sync=1 : 1 là test 2 là lưu DB} ';

	public $categories;

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Worker category sync data';

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
		$this->info("init WorkerCategoryCommand");
		$categories = \DB::table('categories')->where('c_status', Category::STATUS_ACTIVE)->get();
		$this->categories = $categories;

		foreach ($categories as $category) {
			$this->info("---- ID " . $category->id . " [name]: " . $category->c_name);

			if ($category->c_parent_id) {
				$this->warn("----  [Parent]: " . $category->id);
				$listID = DetectCategory::getParentById($category->id);
				$listID = $listID ?? [];

				$this->warn("---- ----  Update c_all_parent " . print_r($listID));

				\DB::table('categories')->where('id', $category->id)
					->update([
						'c_all_parent' => json_encode($listID)
					]);
				array_unshift($listID, $category->id);
				print_r($listID);
			}

			$checkChildID = $category->id;
			$this->convertChildAndCountCategory($checkChildID);

			$this->warn('=============================================');
		}
	}

	public function convertChildAndCountCategory($checkChildID)
	{
		$this->info("---- [Find List Child By id] ". $checkChildID);
		$listChildCategoryByID = DetectCategory::getChildById($this->categories,$checkChildID , 1);
		$count       = 0;
		$listChildID = [];
		if ($listChildCategoryByID) {
			$this->info("---- ---- -- listChildCategoryByID");
			foreach ($listChildCategoryByID as $itemChild) {
				$idItemChild = $itemChild->id;
				$count         += \DB::table('documents')->where('dcm_category_id', $idItemChild)->count();
				$listChildID[] = $itemChild->id;
			}
			array_unshift($listChildID, $checkChildID);
		}else{
			$this->info("---- ---- -- Not listChildCategoryByID");
			$listChildID[] = $checkChildID;
		}
		$count += \DB::table('documents')->where('dcm_category_id', $checkChildID)->count();

		$this->warn("---- ---- Count document by ID: " . $checkChildID ." = ". $count);
		$this->warn("---- ---- Update c_all_child " . print_r($listChildID));
		\DB::table('categories')->where('id', $checkChildID)
			->update([
				'c_all_child'      => json_encode($listChildID),
				'c_count_document' => $count
			]);
	}
}
