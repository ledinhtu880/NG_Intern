<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentSimpleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\ContentPackController;
use App\Http\Controllers\StationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::resource('rawMaterials', RawMaterialController::class);
Route::resource('orders', OrderController::class);
Route::resource('customers', CustomerController::class);
Route::resource('stations', StationController::class);

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout',  [AuthController::class, 'logout'])->name('logout');
Route::group(['prefix' => 'rawMaterials', 'as' => 'rawMaterials.'], function () {
  Route::post('/showMaterials', [RawMaterialController::class, 'showRawMaterialsByType'])->name('showMaterials');
  Route::post('/showUnit', [RawMaterialController::class, 'showUnit'])->name('showUnit');
});
Route::group(['prefix' => 'packs', 'as' => 'packs.'], function () {
  Route::get('/', [ContentPackController::class, 'index'])->name('index');
  Route::get('/create', [ContentPackController::class, 'create'])->name('create');
  Route::get('/createPack', [ContentPackController::class, 'createPack'])->name('createPack');
  Route::post('/storePack', [ContentPackController::class, 'storePack'])->name('storePack');
  Route::post('/storeDetail', [ContentPackController::class, 'storeDetailContentSimpleOfPack'])->name('storeDetailContentSimpleOfPack');
  Route::post('/deletePack', [ContentPackController::class, 'deletePack'])->name('deletePack');
});
Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
  Route::post('/storeOrder', [OrderController::class, 'storeOrder'])->name('storeOrder');
  Route::post('/updateOrder', [OrderController::class, 'updateOrder'])->name('updateOrder');
});
Route::group(['prefix' => 'simples', 'as' => 'simples.'], function () {
  Route::post('/addSimple', [ContentSimpleController::class, 'addSimple'])->name('addSimple');
  Route::post('/storeSimple', [ContentSimpleController::class, 'storeSimple'])->name('storeSimple');
  Route::post('/deleteSimple', [ContentSimpleController::class, 'deleteSimple'])->name('deleteSimple');
  Route::post('/updateSimple', [ContentSimpleController::class, 'updateSimple'])->name('updateSimple');
});

Route::post('/stations/showStation', [StationController::class, 'showStationTypeById'])->name('showStationTypeById');
