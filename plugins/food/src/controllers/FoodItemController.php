<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    /**
     * Will redirect to food itmes list page
     *
     * @return void
     */
    public function foodItmes()
    {
        return view('food::admin.foods.index');
    }

    /**
     * Will redirect to food item adding page
     */
    public function addFoodItmes() {
        return view('food::admin.foods.create');
    }

    /**
     * Will store food itmes
     */
    public function storeFoodItmes(Request $request){
        dd($request->all());
    }
}
