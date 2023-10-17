<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Will redirect to language list
     *
     * @return void
     */
    function index(){
        return view('language.index');        
    }
}
