<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckLoginUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!get_data_user('web'))
        {
			\Session::put('login_redirect_to', $request->path());
			return redirect()->route('get.login');
        }

		if (get_data_user('web','status') == User::STATUS_BLOCK)
			return redirect()->route('get.view_block_user');

		return $next($request);
    }
}
