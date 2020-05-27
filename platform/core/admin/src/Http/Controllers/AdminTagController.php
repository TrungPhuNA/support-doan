<?php

namespace Core\Admin\Http\Controllers;

use App\Http\Requests\AdminRequestTag;
use App\Models\SeoBlog;
use App\Models\Tag;
use Carbon\Carbon;
use Core\Admin\Services\RenderUrlSeoBlogServices;
use Illuminate\Support\Str;

class AdminTagController
{
	public function index()
	{
		$tags = Tag::paginate(10);

		$viewData = [
			'tags' => $tags
		];

		return view('admin::tag.index', $viewData);
	}

	public function create()
	{
		return view('admin::tag.create');
	}

	public function store(AdminRequestTag $request)
	{
		$data               = $request->except('_token');
		$data['t_slug']     = Str::slug($request->t_name);
		$data['created_at'] = Carbon::now();
		$data['t_admin_id'] = get_data_user('admins');

		$id = Tag::insertGetId($data);
		if ($id) {
			RenderUrlSeoBlogServices::renderUrlBLog($data['t_slug'].'-'.SeoBlog::SLUG_TAG.'-'.$id, SeoBlog::TYPE_TAG, $id);
		}

		return redirect()->back();
	}

	public function edit($id)
	{
		$tag = Tag::find($id);
		return view('admin::tag.update', compact('tag'));
	}

	public function update(AdminRequestTag $request, $id)
	{
		$tag                = Tag::find($id);
		$data               = $request->except('_token');
		$data['t_slug']     = Str::slug($request->t_name);
		$data['updated_at'] = Carbon::now();

		$tag->update($data);
		RenderUrlSeoBlogServices::renderUrlBLog($data['t_slug'].'-'.SeoBlog::SLUG_TAG.'-'.$id, SeoBlog::TYPE_TAG, $tag->id);
		return redirect()->back();
	}

	public function hot($id)
	{
		$tag        = Tag::find($id);
		$tag->t_hot = !$tag->t_hot;
		$tag->save();

		return redirect()->back();
	}

	public function delete($id)
	{
		$tag = Tag::find($id);
		if ($tag)
		{
			$slug = $tag->t_slug.'-'.$tag->id.'-'. SeoBlog::SLUG_TAG;
			SeoBlog::where([
				'sb_md5'  => md5($slug),
				'sb_type' => SeoBlog::TYPE_TAG
			])->delete();
			$tag->delete();
		}

		return redirect()->back();
	}
}