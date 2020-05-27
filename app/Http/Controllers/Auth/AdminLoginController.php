<?php


namespace App\Http\Controllers\Auth;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AdminLoginController
{
	use AuthenticatesUsers;

	public function getLoginAdmin()
	{
		return view('auth.admin_login');
	}

	public function postLoginAdmin(Request $request)
	{
		if (\Auth::guard('admins')->attempt(['email' => $request->email, 'password' => $request->password])) {
//            return redirect()->intended('/api-admin');
			return redirect()->route('get.admin.index');
		}

		return redirect()->back();
	}

	public function getLogoutAdmin()
	{
		\Auth::guard('admins')->logout();
		return redirect()->to('/');
	}
}