<?php

namespace Eurostep\Custom\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eurostep:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Eurostep custom files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Publish the Service Provider
        $this->call('vendor:publish', [
            '--provider' => 'Eurostep/Custom/Providers/EurostepServiceProvider',
        ]);

        // Publish the configuration file
        $this->call('vendor:publish', [
            '--tag' => 'config',
        ]);

        $this->updateStorageConfiguration();

        $this->info('Package installed and configured successfully.');
    }

    protected function updateStorageConfiguration()
    {
        // Configure the new adapter for the Eurostep driver
        config(['filesystems.disks.eurostep_root' => [
            'driver' => 'local',
            'root' => storage_path('application-1/public'),
        ]]);

        // Set the configured storage as the default driver
        config(['filesystems.default' => 'eurostep_root']);

        // Reload the configuration cache to reflect the changes
        Artisan::call('config:clear');
        Artisan::call('config:cache');
    }
}
