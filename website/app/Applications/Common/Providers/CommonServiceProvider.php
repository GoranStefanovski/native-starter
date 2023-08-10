<?php

namespace App\Applications\Common\Providers;


use App\Applications\Common\BLL\PostBLL;
use App\Applications\Common\BLL\PostBLLInterface;
use App\Applications\Common\BLL\TaxonomiesBLL;
use App\Applications\Common\BLL\TaxonomiesBLLInterface;
use App\Applications\Common\DAL\TaxonomiesDAL;
use App\Applications\Common\DAL\TaxonomiesDALInterface;
use App\Applications\Common\Model\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Applications\Common\DAL\MediaDAL;
use App\Applications\Common\DAL\MediaDALInterface;

/*INSERT NEW IMPORTS HERE*/

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Set the service provider namespace
     *
     */
    protected $namespace = 'App\Applications\Common';
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
        $this->app->bind(MediaDALInterface::class, MediaDAL::class);
        $this->app->bind(PostBLLInterface::class, PostBLL::class);
        $this->app->bind(TaxonomiesDALInterface::class, TaxonomiesDAL::class);
        $this->app->bind(TaxonomiesBLLInterface::class, TaxonomiesBLL::class);
		/*INSERT NEW BINDINGS HERE*/
    }

    public function map()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/Common/api.php'));
    }

}
