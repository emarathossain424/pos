<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\MediaController;
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

// Auth::logout();

Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('layouts.master');
    });

    Route::resource('plugins', PluginController::class);

    //manage Language
    Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');
    Route::get('/languages/create', [LanguageController::class, 'create'])->name('languages.create');
    Route::post('/languages/store', [LanguageController::class, 'store'])->name('languages.store');
    Route::post('/languages/update', [LanguageController::class, 'update'])->name('languages.update');
    Route::post('/languages/delete', [LanguageController::class, 'delete'])->name('languages.delete');
    Route::get('/translate/{code}', [LanguageController::class, 'translate'])->name('translate');
    Route::post('/update-translations', [LanguageController::class, 'updateTranslations'])->name('update.translations');
    Route::post('/update-language-rtl-status', [LanguageController::class, 'updateLanguageRtlStatus'])->name('update.language.rtl.status');

    //Media Library
    Route::get('/media-library', [MediaController::class, 'media'])->name('media.library');
    Route::post('/media-upload', [MediaController::class, 'uploadMedia'])->name('media.upload');
});


Auth::routes();
