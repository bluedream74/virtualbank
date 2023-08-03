<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    //protected $namespace = 'App\Http\Controllers';
    protected $namespaceCustomer = 'App\Http\Controllers\Customer';
    protected $namespaceMerchant = 'App\Http\Controllers\Merchant';
    protected $namespaceAdmin = 'App\Http\Controllers\Admin';

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

        $this->mapMerchantRoutes();
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
             ->namespace($this->namespaceCustomer)
             ->group(base_path('routes/web.php'));
    }

    protected function mapMerchantRoutes()
    {
        Route::middleware('merchant')
            ->prefix('merchant')
            ->namespace($this->namespaceMerchant)
            ->group(base_path('routes/merchant.php'));
    }

    /**************************************************
     *   Name: mapAdminRoutes()
     *   Function: used for admin routing
     *   Parameter:
     *
     *   Return: array
     *   Created by @kbin 2018/08/30
     *************************************************/
    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->prefix('admin')
            ->namespace($this->namespaceAdmin)
            ->group(base_path('routes/admin.php'));
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
}
