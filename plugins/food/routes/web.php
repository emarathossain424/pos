<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\PluginController;
use Plugin\Food\Controllers\CategoryController;
use Plugin\Food\Controllers\TestController;

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

Route::get('/test-food-plugin', [TestController::class, 'index'])->name('test.controller');

Route::prefix('/food')->middleware('auth')->group(function () {
    Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
    Route::get('/add-category', [CategoryController::class, 'addCategory'])->name('add.category');
    Route::post('/store-category', [CategoryController::class, 'storeCategory'])->name('store.category');
    Route::get('/edit-category/{id}', [CategoryController::class, 'editCategory'])->name('edit.category');
    Route::post('/update-category', [CategoryController::class, 'updateCategory'])->name('update.category');
    Route::post('/delete-category', [CategoryController::class, 'deleteCategory'])->name('delete.category');
});
