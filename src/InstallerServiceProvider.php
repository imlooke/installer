<?php

namespace Imlooke\Installer;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Imlooke\Installer\Middleware\CanInstall;

/**
 * InstallerServiceProvider
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__ . '/../config/installer.php' => config_path('installer.php'),
        ]);
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/installer'),
        ]);
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('install', [CanInstall::class]);
    }
}
