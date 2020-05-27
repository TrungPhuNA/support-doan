<?php

namespace Core\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Hashids\Hashids;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends AdminBaseController
{
    public function index(Request $request)
    {
        $users = User::with('social','presenter:id,name');

        if ($request->email)
        	$users->where('email','like','%'.$request->email.'%');

		if ($request->phone)
			$users->where('phone','like','%'.$request->phone.'%');


		$users  = $users->orderByDesc('id')
			->paginate(20);

        $viewData = [
            'users' => $users,
			'query' => $request->query()
        ];

		if ($request->slug)
		{
			$hashids    = new Hashids('', 50, config('setting._token'));
			$users = User::all();
			foreach ($users as $user)
			{
				$slug   = $hashids->encode($user->id);
				\DB::table('users')->where('id', $user->id)
					->update([
						'slug' => $slug
					]);

			}
		}

        return view('admin::user.index', $viewData);
    }

	/**
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 * Delete user
	 */
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
			\DB::table('social_accounts')
				->where('user_id', $id)->delete();
			$user->delete();
		};

        return redirect()->back();
    }

	/**
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function fakingLogin(Request $request, $id)
	{
		if(\Auth::loginUsingId($id))
			return redirect()->route('get.user.dashboard');

		$this->getMessagesErrors();
		return redirect()->back();
	}

	public function changeStatus($id)
	{
		$user = User::find($id);
		$user->status = $user->status == 1 ? -1 : 1;
		$user->save();

		$this->getMessagesSuccess();
		return redirect()->back();
	}

	public function veryAccount($id)
	{
		$user = User::find($id);
		$user->status = User::STATUS_ACTIVE;
		$user->save();

		$this->getMessagesSuccess();
		return redirect()->back();
	}

	public function changePassword($id)
	{
		$user = User::find($id);
		$user->password = Hash::make('tailieu247');
		$user->save();
		return redirect()->back();
	}
}
