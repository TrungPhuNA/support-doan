<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoginAdmin
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
        if (get_data_user('admins') && get_data_user('admins','status') == 1) {
            return $next($request);
        }
        
        return redirect()->to('/');
    }
}
