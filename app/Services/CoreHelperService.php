<?php

namespace App\Services;

use App\Models\Plugin;

class CoreHelperService{

    /**
     * Will check if plugin active by plugin id
     */
    public function isActivePlugin($id){
        return false;
    }

    /**
     * Will return all active plugins
     */
    public function getActivePlugins(){
        return Plugin::where('status',1)->get();
    }
}