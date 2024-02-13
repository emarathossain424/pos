<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Plugin;

class PluginController extends Controller
{
    /**
     * Will redirect to plugin list
     */
    public function index()
    {
        $plugins = Plugin::all();
        return view('plugins.index', compact('plugins'));
    }
}
