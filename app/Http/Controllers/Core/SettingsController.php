<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;

class SettingsController extends Controller {

    public function generalSettings() {
        return view( 'settings.general' );
    }
}