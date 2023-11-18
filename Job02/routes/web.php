<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentSimpleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RawMaterialController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::resource('rawMaterials', RawMaterialController::class);
Route::resource('orders', OrderController::class);
Route::resource('customers', CustomerController::class);

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout',  [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'rawMaterials', 'as' => 'rawMaterial.'], function () {
  Route::post('/showMaterials', [RawMaterialController::class, 'showRawMaterialsByType'])->name('showMaterials');
  Route::post('/showUnit', [RawMaterialController::class, 'showUnit'])->name('showUnit');
});
Route::group(['prefix' => 'orders', 'as' => 'order.'], function () {
  Route::post('/storeOrder', [OrderController::class, 'storeOrder'])->name('storeOrder');
  Route::post('/updateOrder', [OrderController::class, 'updateOrder'])->name('updateOrder');
});
Route::group(['prefix' => 'contentSimples', 'as' => 'contentSimple.'], function () {
  Route::post('/addProduct', [ContentSimpleController::class, 'addProduct'])->name('addProduct');
  Route::post('/storeProduct', [ContentSimpleController::class, 'storeProduct'])->name('storeProduct');
  Route::post('/deleteProduct', [ContentSimpleController::class, 'deleteProduct'])->name('deleteProduct');
  Route::post('/updateProduct', [ContentSimpleController::class, 'updateProduct'])->name('updateOrder');
});
