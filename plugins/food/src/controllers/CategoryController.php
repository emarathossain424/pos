<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Will redirect to food category page
     *
     * @return void
     */
    public function categories(){
        return view('food::admin.category.index');
    }

    /**
     * Will redirect to category ceation page
     *
     * @return void
     */
    public function addCategory() {
        return view('food::admin.category.create');
    }
}