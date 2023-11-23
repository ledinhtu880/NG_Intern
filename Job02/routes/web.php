<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentSimpleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\ContentPackController;
use App\Http\Controllers\ProductionStationLineController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\WareController;
use App\Http\Controllers\OrderMakeOrExpeditionController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'checklogin'])->name('checkLogin');
Route::get('/logout',  [AuthController::class, 'logout'])->name('logout');

Route::middleware('checklogin')->group(function () {
  Route::get('/', [HomeController::class, 'index'])->name('index');
  Route::resource('rawMaterials', RawMaterialController::class);
  Route::resource('orders', OrderController::class);
  Route::resource('customers', CustomerController::class);
  Route::resource('stations', StationController::class);
  Route::resource('productionStationLines', ProductionStationLineController::class);

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

  Route::group(['prefix' => 'productionStationLines', 'as' => 'productionStationLines.'], function () {
    Route::post('/{id}', [ProductionStationLineController::class, 'store'])->name('store');
    Route::post('/update/{id}', [ProductionStationLineController::class, 'update'])->name('update');
  });

  Route::group(['prefix' => 'makesOrExpeditions', 'as' => 'makesOrExpeditions.'], function () {
    Route::get('/', [OrderMakeOrExpeditionController::class, 'index'])->name('index');
    Route::get('/create', [OrderMakeOrExpeditionController::class, 'create'])->name('create');
    Route::post('/store', [OrderMakeOrExpeditionController::class, 'store'])->name('store');
    Route::post('/show', [OrderMakeOrExpeditionController::class, 'show'])->name('show');
    Route::post('/destroy', [OrderMakeOrExpeditionController::class, 'destroy'])->name('destroy');
  });

  Route::group(['prefix' => 'wares', 'as' => 'wares.'], function () {
    Route::get('/', [WareController::class, 'index'])->name('index');
    Route::get('/create', [WareController::class, 'create'])->name('create');
    Route::get('/{id}', [WareController::class, 'show'])->name('show');
    Route::post('createWare', [WareController::class, 'createWare']);
    Route::post('show', [WareController::class, 'showDetails']);
    Route::post('setCellStatus', [WareController::class, 'setCellStatus']);
  });
  Route::post('/stations/showStation', [StationController::class, 'showStationTypeById'])->name('showStationTypeById');
});
