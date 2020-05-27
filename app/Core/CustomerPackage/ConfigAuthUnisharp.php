<?php


namespace App\Core\CustomerPackage;


class ConfigAuthUnisharp
{
	public function userField()
	{
		return \Auth::guard('admins')->user()->id;
	}
}