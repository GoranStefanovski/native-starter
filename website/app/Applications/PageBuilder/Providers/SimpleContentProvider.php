<?php

namespace App\Applications\PageBuilder\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Applications\PageBuilder\BLL\SimpleContentBLL;
use App\Applications\PageBuilder\BLL\SimpleContentBLLInterface;
use App\Applications\PageBuilder\DAL\SimpleContentDAL;
use App\Applications\PageBuilder\DAL\SimpleContentDALInterface;
/*INSERT NEW IMPORTS HERE*/

class SimpleContentProvider extends ServiceProvider
{
    /**
     * Set the service provider namespace
     *
     */
    protected $namespace = 'App\Applications\PageBuilder';
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->routesAreCached()) {
         //  This is already done in the main RouteServiceProvider so not needed here
        } else {

            $this->app->call([$this, 'map']);

            $this->app->booted(function () {
                $this->app['router']->getRoutes()->refreshNameLookups();
                $this->app['router']->getRoutes()->refreshActionLookups();
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SimpleContentBLLInterface::class, SimpleContentBLL::class);
        $this->app->bind(SimpleContentDALInterface::class, SimpleContentDAL::class);
		/*INSERT NEW BINDINGS HERE*/
    }

    public function map()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/PageBuilder/api.php'));
    }

}
