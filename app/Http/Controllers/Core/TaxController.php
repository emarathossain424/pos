<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;

class TaxController extends Controller {

    public function allTaxes() {
        // $branches = Branch::all();
        $taxes = [];
        return view( 'settings.tax.index', compact( 'taxes' ) );
    }
}