<?php


namespace App\Http\Middleware;


use App\User;

class CheckUpdateInfoUser
{
	public function handle($request, \Closure $next)
	{
		if (get_data_user('web') &&
			(!get_data_user('web','phone') ||
				!get_data_user('web','email')))
		{
			\Session::flash('toastr', [
				'type'    => 'error',
				'message' => 'Mời bạn cập nhật đầy đủ thông tin'
			]);

			return redirect()->route('get.user.update_info');
		}

		return $next($request);
	}
}