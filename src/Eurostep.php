<?php
namespace Eurostep\Custom;

use Illuminate\Support\Facades\Storage;

class Eurostep
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Configure the eurostep storage package to store the files into the selected storage
     *
     * @param $appName
     * @return void
     */
    public function configure($appName)
    {
        // Get storage_root from the config file that we injected from constructor
        $storageRoot = rtrim($this->config['storage_root'], '/');
        // Fill out the storage path with storage root and appname that we get from appName variable
        $storagePath = $storageRoot . '/' . $appName;

        // Configure the storage adapter with the new path
        config(['filesystems.disks.eurostep_root' => [
            'driver' => 'local',
            'root' => storage_path($storagePath),
        ]]);
    }

    /**
     * Configure the storage configuration from filesystems
     *
     * @param $disk
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function storage($disk = null)
    {
        return Storage::disk($disk);
    }
}
