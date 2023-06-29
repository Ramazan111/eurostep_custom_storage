<?php
namespace Eurostep\Custom\Providers;

use Eurostep\Custom\Console\Commands\InstallCommand;
use Eurostep\Custom\Eurostep;
use Illuminate\Support\ServiceProvider;

class EurostepServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->publishes([
            __DIR__ . '/../../config/eurostep.php' => config_path('eurostep.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../../config/eurostep.php', 'eurostep');

        $this->app->bind('eurostep', function ($app) {
            return new Eurostep($app->config->get('eurostep'));
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }

    }
}
