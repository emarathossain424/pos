<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\PluginController;
use App\Http\Controllers\Core\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.master');
});

Route::prefix('/')->group(function(){
    Route::resource('plugins', PluginController::class);

    //manage Language
    Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');
    Route::get('/languages/create', [LanguageController::class, 'create'])->name('languages.create');
    Route::post('/languages', [LanguageController::class, 'store'])->name('languages.store');

    Route::post('/languages/update', [LanguageController::class, 'update'])->name('languages.update');
});

