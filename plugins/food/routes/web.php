<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\PluginController;
use Plugin\Food\Controllers\CategoryController;
use Plugin\Food\Controllers\FoodItemController;
use Plugin\Food\Controllers\TestController;
use Plugin\Food\Controllers\VariationController;

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
    Route::post('/update-category-status', [CategoryController::class, 'updateCategoryStatus'])->name('update.category.status');

    Route::get('/items', [FoodItemController::class, 'foodItems'])->name('food.items');
    Route::get('/add-food-items', [FoodItemController::class, 'addFoodItems'])->name('add.food.items');
    Route::post('/store-food-items', [FoodItemController::class, 'storeFoodItems'])->name('store.food.items');
    Route::get('/items/{id}', [FoodItemController::class, 'editFoodItems'])->name('edit.food.item');
    Route::post('/update-food-items', [FoodItemController::class, 'updateFoodItems'])->name('update.food.items');
    Route::post('/delete-food-item', [FoodItemController::class, 'deleteFoodItem'])->name('delete.food.item');
    Route::post('/update-item-status',[FoodItemController::class,'updateItemStatus'])->name('update.item.status');
    
    Route::get('/all-variations',[VariationController::class,'variations'])->name('variations');
    Route::get('/create-variant',[VariationController::class,'variations'])->name('create.variant');
});
