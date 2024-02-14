<?php

namespace App\Services;

use App\Models\Plugin;

class PluginService
{

    /**
     * Will check if plugin active by plugin id
     */
    public function isActivePlugin($id)
    {
        return false;
    }

    /**
     * Will return all active plugins
     */
    public function getActivePlugins()
    {
        return Plugin::where('status', 1)->get();
    }

    /**
     * will return all active plugins navigation location
     */
    public function getActivePluginNavigationLocation()
    {
        $active_plugins = $this->getActivePlugins();
        $items = [];
        foreach ($active_plugins as $plugin) {
            $new_item = $plugin->location . '::admin.layouts.sidebar';
            array_push($items, $new_item);
        }
        return $items;
    }
}
