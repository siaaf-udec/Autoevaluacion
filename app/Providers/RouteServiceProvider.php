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
    protected $namespace = 'App\Http\Controllers';

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

        $this->mapSuperAdminRoutes();

        $this->mapFuentesPrimariasRoutes();

        $this->mapFuentesSecundariasRoutes();

        //
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

    /**
     * Define the "super administrador" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapSuperAdminRoutes()
    {
        Route::prefix('admin')
             ->middleware(['web', 'auth'])
             ->namespace($this->namespace . '\SuperAdministrador')
             ->group(base_path('routes/superAdministrador.php'));
    }

    /**
     * Define the "fuentes primarias" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapFuentesPrimariasRoutes()
    {
        Route::prefix('admin/fuentesPrimarias')
             ->middleware(['web', 'auth'])
             ->namespace($this->namespace . '\fuentesPrimarias')
             ->group(base_path('routes/fuentesPrimarias.php'));
    }

    /**
     * Define the "fuentes secundarias" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapFuentesSecundariasRoutes()
    {
        Route::prefix('admin/fuentesSecundarias')
             ->middleware(['web', 'auth'])
             ->namespace($this->namespace . '\fuentesSecundarias')
             ->group(base_path('routes/fuentesSecundarias.php'));
    }
}
