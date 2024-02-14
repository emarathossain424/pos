<?php

namespace Plugin\Food\Controllers;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function categories(){
        return view('food::admin.category.index');
    }
}