<?php
namespace Core\Acl;

use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/Resources/views', 'acl');
	}

	public function register()
	{
		$this->mergeConfigFrom(__DIR__.'/../config/acl.php', 'acl');
	}
}