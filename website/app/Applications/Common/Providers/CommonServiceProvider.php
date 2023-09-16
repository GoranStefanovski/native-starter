<?php

namespace App\Applications\Common\Providers;


use App\Applications\Common\BLL\LocationBLL;
use App\Applications\Common\BLL\LocationBLLInterface;
use App\Applications\Common\BLL\EventBLL;
use App\Applications\Common\BLL\EventBLLInterface;
use App\Applications\Common\BLL\WorkingHoursBLL;
use App\Applications\Common\BLL\WorkingHoursBLLInterface;
use App\Applications\Common\BLL\TaxonomiesBLL;
use App\Applications\Common\BLL\TaxonomiesBLLInterface;
use App\Applications\Common\DAL\TaxonomiesDAL;
use App\Applications\Common\DAL\TaxonomiesDALInterface;
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
        $this->app->bind(EventBLLInterface::class, EventBLL::class);
        $this->app->bind(WorkingHoursBLLInterface::class, WorkingHoursBLL::class);
        $this->app->bind(LocationBLLInterface::class, LocationBLL::class);
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
