<?php

namespace Core\Blog\Http\Controllers;

use App\Models\SeoBlog;
use Illuminate\Http\Request;

class BlogHubController
{
	public function renderUrl(Request $request, $slug)
	{
		$seoBlog = SeoBlog::where('sb_md5', md5($slug))->first();
		if (!$seoBlog) return redirect()->route('get.blog.home');

		$type = $seoBlog->sb_type;
		switch ($type) {
			case SeoBlog::TYPE_TAG:

				return (new TagBlogController())->index($seoBlog->sb_id);
				break;

			case SeoBlog::TYPE_MENU:
				return (new MenuBlogController())->index($seoBlog->sb_id);
				break;

			case SeoBlog::TYPE_ARTICLE:
				return (new ArticleDetailBlogController())->index($seoBlog->sb_id);
				break;
		}

		return redirect()->to('/');
	}
}