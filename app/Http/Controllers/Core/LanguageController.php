<?php

namespace App\Http\Controllers\Core;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\StoreLanguageRequest;

class LanguageController extends Controller
{
    /**
     * Will redirect to language list
     *
     * @return void
     */
    function index(){
        $languages = Language::all();
        return view('language.index',compact('languages'));        
    }
    
    /**
     * Will create new language
     */
    public function store(StoreLanguageRequest $request)
    {
        Language::create([
            'name'=>$request['name'],
            'code'=>$request['code']
        ]);

        return back();
    }

    /**
     * Will update requested language
     *
     * @return void
     */
    public function update(StoreLanguageRequest $request) {
        $language = Language::find($request['id']);
        $language->name = $request['name'];
        $language->code = $request['code'];
        $language->update();

        Toastr::success('Messages in here', 'Title');
        return back();
    }
}
