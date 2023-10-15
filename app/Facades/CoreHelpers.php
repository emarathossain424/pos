<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CoreHelpers extends Facade{

    /**
     * Will check if plugin active by plugin id
     */
    protected static function getFacadeAccessor(){
        return 'core-helpers';
    }
}