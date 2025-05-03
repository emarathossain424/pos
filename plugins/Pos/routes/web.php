<?php

use Illuminate\Support\Facades\Route;
use Plugin\Pos\Controllers\PosController;

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

Route::prefix('/pos')->middleware('auth')->group(function () {
    Route::get('/', [PosController::class, 'index'])->name('pos');
    Route::get('/item-search', [PosController::class, 'itemSearch'])->name('pos.item.search');
    Route::post('/add-to-cart', [PosController::class, 'posAddToCart'])->name('pos.add.to.cart');
    Route::post('/place-order', [PosController::class, 'placeOrder'])->name('pos.place.order');
    Route::get('/print-invoice/{order_id}', [PosController::class, 'printInvoice'])->name('pos.print.invoice');
});
