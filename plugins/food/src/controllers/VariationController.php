<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Plugin\Food\Models\FoodVariant;

class VariationController extends Controller
{
    /**
     * Will redirect to food item variation list page
     *
     * @return void
     */
    public function variations(Request $request)
    {
        $variants = FoodVariant::with('options')->get();
        // dd($variants[0]->options);
        return view('food::admin.variation.index', compact('variants'));
    }
}
