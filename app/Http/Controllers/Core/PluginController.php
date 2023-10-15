<?php

namespace App\Http\Controllers\Core;

use App\Facades\CoreHelpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PluginController extends Controller
{
    /**
     * Will redirect to plugin list
     */
    public function index(){
        dd(CoreHelpers::isActivePlugin(123));
        return view('plugins.index');
    }
}