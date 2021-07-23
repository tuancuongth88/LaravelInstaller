<?php

namespace cuongnt\LaravelSetup\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use cuongnt\LaravelSetup\Middleware\canInstall;
use cuongnt\LaravelSetup\Middleware\canUpdate;

class LaravelSetupServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }

    /**
     * Bootstrap the application events.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('install', [CanInstall::class]);
        $router->middlewareGroup('update', [CanUpdate::class]);
    }

    /**
     * Publish config file for the Setup.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__.'/../Config/installer.php' => base_path('config/installer.php'),
        ], 'laravel_setup');

        $this->publishes([
            __DIR__.'/../assets' => public_path('installer'),
        ], 'laravel_setup');

        $this->publishes([
            __DIR__.'/../Views' => base_path('resources/views/vendor/setup'),
        ], 'laravel_setup');

        $this->publishes([
            __DIR__.'/../Lang' => base_path('resources/lang'),
        ], 'laravel_setup');
    }
}
