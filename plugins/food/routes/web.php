<?php

use Illuminate\Support\Facades\Route;
use Plugin\Food\Controllers\CategoryController;
use Plugin\Food\Controllers\FoodItemController;
use Plugin\Food\Controllers\PropertyController;
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

Route::get( '/test-food-plugin', [TestController::class, 'index'] )->name( 'test.controller' );

Route::prefix( '/food' )->middleware( 'auth' )->group( function () {
    Route::get( '/categories', [CategoryController::class, 'categories'] )->name( 'categories' );
    Route::get( '/add-category', [CategoryController::class, 'addCategory'] )->name( 'add.category' );
    Route::post( '/store-category', [CategoryController::class, 'storeCategory'] )->name( 'store.category' );
    Route::get( '/edit-category/{id}', [CategoryController::class, 'editCategory'] )->name( 'edit.category' );
    Route::post( '/update-category', [CategoryController::class, 'updateCategory'] )->name( 'update.category' );
    Route::post( '/delete-category', [CategoryController::class, 'deleteCategory'] )->name( 'delete.category' );
    Route::post( '/update-category-status', [CategoryController::class, 'updateCategoryStatus'] )->name( 'update.category.status' );

    Route::get( '/items', [FoodItemController::class, 'foodItems'] )->name( 'food.items' );
    Route::get( '/add-food-items', [FoodItemController::class, 'addFoodItems'] )->name( 'add.food.items' );
    Route::post( '/store-food-items', [FoodItemController::class, 'storeFoodItems'] )->name( 'store.food.items' );
    Route::get( '/items/{id}', [FoodItemController::class, 'editFoodItems'] )->name( 'edit.food.item' );
    Route::post( '/update-food-items', [FoodItemController::class, 'updateFoodItems'] )->name( 'update.food.items' );
    Route::post( '/delete-food-item', [FoodItemController::class, 'deleteFoodItem'] )->name( 'delete.food.item' );
    Route::post( '/update-item-status', [FoodItemController::class, 'updateItemStatus'] )->name( 'update.item.status' );

    Route::get( '/all-variations', [VariationController::class, 'variations'] )->name( 'variations' );
    Route::post( '/create-variant', [VariationController::class, 'createVariant'] )->name( 'create.variant' );
    Route::post( '/update-variant', [VariationController::class, 'updateVariant'] )->name( 'update.variant' );
    Route::post( '/delete-variant', [VariationController::class, 'deleteVariant'] )->name( 'delete.variant' );

    Route::post( '/update-option', [VariationController::class, 'updateOption'] )->name( 'update.option' );
    Route::post( '/delete-option', [VariationController::class, 'deleteOption'] )->name( 'delete.option' );
    Route::post( '/add-option', [VariationController::class, 'addOption'] )->name( 'add.option' );

    Route::get( '/get-variant-translation', [VariationController::class, 'getVariantTranslation'] )->name( 'get.variant.translation' );
    Route::get( '/get-option-translation', [VariationController::class, 'getOptionTranslation'] )->name( 'get.option.translation' );

    Route::get( '/all-properties', [PropertyController::class, 'properties'] )->name( 'properties' );
    Route::post( '/create-property', [PropertyController::class, 'createProperty'] )->name( 'create.property' );
    Route::post( '/update-property', [PropertyController::class, 'updateProperty'] )->name( 'update.property' );
    Route::post( '/delete-property', [PropertyController::class, 'deleteProperty'] )->name( 'delete.property' );

    Route::post( '/update-item', [PropertyController::class, 'updateItem'] )->name( 'update.item' );
    Route::post( '/delete-item', [PropertyController::class, 'deleteItem'] )->name( 'delete.item' );
    Route::post( '/add-item', [PropertyController::class, 'addItem'] )->name( 'add.item' );

    Route::get( '/get-property-translation', [PropertyController::class, 'getPropertyTranslation'] )->name( 'get.property.translation' );
    Route::get( '/get-item-translation', [PropertyController::class, 'getItemTranslation'] )->name( 'get.item.translation' );

    Route::get( '/get-property-items', [PropertyController::class, 'getPropertyItems'] )->name( 'get.property.items' );

} );
