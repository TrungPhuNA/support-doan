<?php

namespace Core\Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequestCategory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Category;

class AdminCategoryController extends AdminBaseController
{
    public function index()
    {
        $viewData = [
            'categories' => $this->getCategoriesSort()
        ];

        return view('admin::category.index', $viewData);
    }

    public function create()
    {
        $categories = $this->getCategoriesSort();
        return view('admin::category.create',compact('categories'));
    }

    public function store(AdminRequestCategory $request)
    {
        $data               = $request->except('_token','c_avatar');
        $data['c_slug']     = Str::slug($request->c_name);
        $data['created_at'] = Carbon::now();
        if ($request->c_avatar) {
            $image = upload_image('c_avatar');
            if ($image['code'] == 1)
                $data['c_avatar'] = $image['name'];
        }

        $id = Category::insertGetId($data);
        if ($id)
		{
			$this->getMessagesSuccess();
			if ($parentID = $request->c_parent_id)
			{
				\DB::table('categories')->where('id', $parentID)
					->increment('c_count_document');
				\DB::table('categories')->where('id', $parentID)
					->increment('c_is_parent');
			}
		}
        return redirect()->back();
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $categories = $this->getCategoriesSort();
        return view('admin::category.update', compact('category','categories'));
    }

    public function update(AdminRequestCategory $request, $id)
    {
        $category           = Category::find($id);
        $parentOld = $category->c_parent_id;
        $data               = $request->except('_token','c_avatar');
        $data['c_slug']     = Str::slug($request->c_name);
        $data['updated_at'] = Carbon::now();

        if ($request->c_avatar) {
            $image = upload_image('c_avatar');
            if ($image['code'] == 1)
                $data['c_avatar'] = $image['name'];
        }

        $category->update($data);

        if ($parentOld != $category->c_parent_id)
		{
			\DB::table('categories')->where('id', $category->c_parent_id)
				->increment('c_count_document');

			\DB::table('categories')->where('id', $category->c_parent_id)
				->increment('c_is_parent');

			\DB::table('categories')->where('id', $parentOld)
				->decrement('c_count_document');

			\DB::table('categories')->where('id', $parentOld)
				->decrement('c_is_parent');
		}

        return redirect()->back();
    }

    public function active($id)
    {
        $category = Category::find($id);
        $category->c_status = ! $category->c_status;
        $category->save();

        return redirect()->back();
    }

    public function hot($id)
    {
        $category = Category::find($id);
        $category->c_hot = !$category->c_hot;
        $category->save();

        return redirect()->back();
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if ($category) {
			$category->delete();
			\DB::table('categories')->where('id', $category->c_parent_id)
				->decrement('c_count_document');
		}

        return redirect()->back();
    }

    protected function getCategoriesSort()
    {
        $categories = Category::where('c_status', Category::STATUS_ACTIVE)
            ->select('id', 'c_parent_id', 'c_name','c_slug','c_count_document','c_hot')->get();

        $listCategoriesSort = [];
        Category::recursive($categories, $parent = 0, $level = 1, $listCategoriesSort);
        return $listCategoriesSort;
    }
}
