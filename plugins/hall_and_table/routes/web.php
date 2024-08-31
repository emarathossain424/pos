<?php

use Illuminate\Support\Facades\Route;
use Plugin\HallAndTable\Controllers\HallAndTableController;

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

Route::get( '/all-halls', [HallAndTableController::class, 'allHalls'] )->name( 'all.halls' );
Route::post( '/create-hall', [HallAndTableController::class, 'createHall'] )->name( 'create.hall' );
Route::post( '/update-hall', [HallAndTableController::class, 'updateHall'] )->name( 'update.hall' );
Route::post( '/delete-hall', [HallAndTableController::class, 'deleteHall'] )->name( 'delete.hall' );
