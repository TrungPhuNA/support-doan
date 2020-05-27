<?php

namespace Core\User;

use \Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->registerRoute();
		$this->publishConfig();
		$this->loadViewsFrom(__DIR__.'/Resources/views', 'user');
	}

	public function register()
	{

	}

	private function registerRoute()
	{

	}

	private function publishConfig()
	{

	}
}