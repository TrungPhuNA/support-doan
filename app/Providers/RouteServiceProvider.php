<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $namespaceAdmin = 'Core\Admin\Http\Controllers';
	protected $namespaceUser = 'Core\User\Http\Controllers';
	protected $namespaceAcl = 'Core\Acl\Http\Controllers';
	protected $namespaceBlog = 'Core\Blog\Http\Controllers';
	protected $namespaceTest = 'Core\Test\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
     public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
        $this->mapUserRoutes();
        $this->mapAclRoutes();
        $this->mapBlogRoutes();
        $this->mapTestRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::namespace($this->namespaceAdmin)
            ->middleware(['web','check_admin_login'])
             ->group(base_path('platform/core/admin/src/routes.php'));
    }

    protected function mapUserRoutes()
    {
        Route::namespace($this->namespaceUser)
            ->middleware(['web','check_user_login'])
             ->group(base_path('platform/core/user/src/routes.php'));
    }

	protected function mapAclRoutes()
	{
		Route::namespace($this->namespaceAcl)
			->middleware(['web','check_admin_login'])
			->group(base_path('platform/core/acl/src/routes.php'));
	}

	protected function mapBlogRoutes()
	{
		Route::namespace($this->namespaceBlog)
			->middleware(['web'])
			->group(base_path('platform/core/blog/src/routes.php'));
	}

	protected function mapTestRoutes()
	{
		Route::namespace($this->namespaceTest)
			->middleware(['web'])
			->group(base_path('platform/core/test/src/routes.php'));
	}

}
