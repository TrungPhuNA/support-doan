<?php

namespace Core\MetaSeo;

use \Illuminate\Support\ServiceProvider;

class MetaSeoServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->registerRoute();
		$this->publishConfig();
	}

	public function register()
	{

	}

	private function registerRoute()
	{
		$this->loadRoutesFrom(__DIR__.'/routes.php');
	}

	private function publishConfig()
	{
		$this->publishes([
			__DIR__.'/../config/meta_seo.php' => config_path('meta_seo.php')
		], 'config');
	}
}