<?php

namespace App\Console\Commands;

use App\HelpersClass\DetectCategory;
use App\Models\Category;
use Illuminate\Console\Command;

class ConvertCategoryCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'category:init';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Convert category';

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
		$categories = \DB::table('categories')->get();
//		$this->checkParent($categories);
		$this->getAllChildCategories($categories);
	}

	protected function checkParent($categories)
	{
		\DB::table('categories')
			->update([
				'c_is_parent' => 0
			]);

		foreach ($categories as $category) {
			$this->info("ID: ". $category->id);
			$checkChild = Category::where('id', $category->c_parent_id)->first();
			if ($checkChild)
			{
				\DB::table('categories')
					->where('id', $category->c_parent_id)
					->increment('c_is_parent');
			}
		}
	}

	protected function countDocument($categories)
	{
		\DB::table('categories')
			->update([
				'c_count_document' => 0
			]);

		foreach ($categories as $category) {
			$this->info("ID: ". $category->id);
			$count = \DB::table('documents')->where('dcm_category_id', $category->id)->count();

			\DB::table('categories')
				->where('id', $category->id)
				->increment('c_count_document', $count);
		}
	}

	protected function getAllChildCategories($categories)
	{
		foreach ($categories as $category)
		{
			$this->info("ID: ". $category->id ." [Name] ". $category->c_name);
			if ($category->c_parent_id)
			{
				$this->warn("----  [Parent]: ".$category->id);
				$listID = DetectCategory::getParentById($category->id);
				$listID = $listID ?? [];
				\DB::table('categories')->where('id', $category->id)
					->update([
						'c_all_parent' => json_encode($listID)
					]);
			}
		}
	}
}
