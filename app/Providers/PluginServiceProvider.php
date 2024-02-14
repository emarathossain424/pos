<?php

namespace App\Providers;

use App\Facades\PluginService;
use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $plugins = PluginService::getActivePlugins();
        foreach ($plugins as $plugin) {
            //Merge config
            $has_config = file_exists(base_path('plugins/' . $plugin->location . '/config/config.php'));
            if ($has_config) {
                $this->mergeConfigFrom(base_path('plugins/' . $plugin->location . '/config/config.php'), $plugin->location);
            }
            
            //Load helper
            $has_helpers = file_exists(base_path('plugins/' . $plugin->location . '/helpers/helpers.php'));
            if ($has_helpers) {
                require_once(base_path('plugins/' . $plugin->location . '/helpers/helpers.php'));
            }

            //Load view
            $this->loadViewsFrom(base_path('plugins/' . $plugin->location . '/views'), $plugin->location);

            //Generate Namespace
            $loader = new ClassLoader;
            $loader->setPsr4($plugin->namespace, base_path('plugins/' . $plugin->location . '/src'));
            $loader->register(true);
        }
    }
}
