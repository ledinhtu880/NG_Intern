<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RawMaterialController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('/rawMaterials/showMaterials', [RawMaterialController::class, 'showRawMaterialsByType'])->name('showMaterials');
Route::resource('rawMaterials', RawMaterialController::class);
Route::resource('orders', OrderController::class);
Route::resource('customers', CustomerController::class);

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout',  [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'orders', 'as' => 'order.'], function () {
  Route::post('/storeOrder', [OrderController::class, 'storeOrder'])->name('storeOrder');
  Route::post('/addProduct', [OrderController::class, 'addProduct'])->name('addProduct');
  Route::post('/storeProduct', [OrderController::class, 'storeProduct'])->name('storeProduct');
});
