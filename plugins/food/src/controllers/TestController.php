<?php

namespace Plugin\Food\Controllers;

use Exception;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\StoreLanguageRequest;

class TestController extends Controller
{
    /**
     * test newly created plugin controller
     */
    function index()
    {
        info('controller - success');
        info(config('food'));
        info(testFoodFunction());
        
        info(config('food.test'));
    }
}