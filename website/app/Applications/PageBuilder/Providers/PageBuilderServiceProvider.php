<?php
namespace App\Applications\PageBuilder\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

use App\Applications\PageBuilder\BLL\PageBLL;
use App\Applications\PageBuilder\BLL\PageBLLInterface;
use App\Applications\PageBuilder\DAL\PageDAL;
use App\Applications\PageBuilder\DAL\PageDALInterface;

class PageBuilderServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Applications\PageBuilder';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PageBLLInterface::class, PageBLL::class);
        $this->app->bind(PageDALInterface::class, PageDAL::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->routesAreCached()) {
            //  This is already done in the main RouteServiceProvider so not needed here
        } else {
            $this->app->call([$this, 'mapRoutes']);

            $this->app->booted(function () {
                $this->app['router']->getRoutes()->refreshNameLookups();
                $this->app['router']->getRoutes()->refreshActionLookups();
            });
        }
    }

    /**
     * Map the routes for the PageBuilder module.
     *
     * @return void
     */
    public function mapRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/PageBuilder/api.php'));
    }
}
