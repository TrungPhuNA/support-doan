<?php

namespace Core\Admin\Services;

use App\Models\SeoBlog;

class RenderUrlSeoBlogServices
{
	public static function renderUrlBLog(string $slug, int $type, int $id)
	{
		$checkUrlSeoBlog = SeoBlog::where([
			'sb_md5'  => md5($slug),
			'sb_type' => $type
		])->first();

		if (!$checkUrlSeoBlog) {
			SeoBlog::insert([
				'sb_md5'  => md5($slug),
				'sb_type' => $type,
				'sb_id'   => $id
			]);
		}
	}
}