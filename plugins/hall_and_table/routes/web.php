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

//Halls controllers
Route::get( '/all-halls', [HallAndTableController::class, 'allHalls'] )->name( 'all.halls' );
Route::post( '/create-hall', [HallAndTableController::class, 'createHall'] )->name( 'create.hall' );
Route::post( '/update-hall', [HallAndTableController::class, 'updateHall'] )->name( 'update.hall' );
Route::post( '/delete-hall', [HallAndTableController::class, 'deleteHall'] )->name( 'delete.hall' );

//Tables controllers
Route::get( '/all-tables/{hall_id}', [HallAndTableController::class, 'allTables'] )->name( 'all.tables' );
Route::post( '/create-table', [HallAndTableController::class, 'createTable'] )->name( 'create.table' );
Route::post( '/update-table', [HallAndTableController::class, 'updateTable'] )->name( 'update.table' );
Route::post( '/delete-table', [HallAndTableController::class, 'deleteTable'] )->name( 'delete.table' );
