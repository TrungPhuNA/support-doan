<?php


namespace Core\User\Http\Controllers;


use App\Http\Controllers\Controller;
use App\User;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;

class UserFriendController extends Controller
{
	public function getListFriendById(Request $request)
	{
		$users = User::where('parent_id', get_data_user('web'));
		if ($request->id)
			$users->where('id', $request->id);

		$users = $users
				->orderByDesc('id')
				->paginate(20);

		$optionsMeta = [
			'meta_title'       => 'Danh sách bạn bè',
		];

		$metaSeo = RenderMetaSeo::MetaSeo($optionsMeta);

		$viewData = [
			'metaSeo' => $metaSeo,
			'users'   => $users,
			'query' => $request->query()
		];

		return view('user::pages.friend_by_user', $viewData);
	}
}