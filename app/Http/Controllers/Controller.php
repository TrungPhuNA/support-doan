<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function redirectTo($name_session)
	{
		$redirectTo = \Session::get($name_session);
		$redirectTo = $redirectTo ? $redirectTo : '/';
		\Session::forget($name_session);

		return $redirectTo;
	}
}
