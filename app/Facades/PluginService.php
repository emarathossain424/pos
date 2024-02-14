<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PluginService extends Facade{

    protected static function getFacadeAccessor(){
        return 'plugin-service';
    }
}