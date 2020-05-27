<?php

namespace Core\Test;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/Resources/views', 'test');
	}
}