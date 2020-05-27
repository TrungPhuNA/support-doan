<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/6/19
 * Time: 11:12 AM
 */

namespace App\Http\Middleware;


use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
	public function handle($request, Closure $next, $permission)
	{
		$permissions = is_array($permission)
			? $permission
			: explode('|', $permission);

		$admin = \Auth::guard('admins')->user();

		foreach ($permissions as $permission) {
			if ($admin->can($permission)) {
				return $next($request);
			}
		}

		throw UnauthorizedException::forPermissions($permissions);
	}
}
