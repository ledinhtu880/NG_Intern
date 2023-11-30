<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentSimpleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\ContentPackController;
use App\Http\Controllers\WareController;
use App\Http\Controllers\DispatchController;
use App\Http\Controllers\OrderLocalController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\ProductStationLineController;
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
  Route::resource('productStationLines', ProductStationLineController::class);

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
    Route::delete('/deleteOrder/{Id_Order}', [ContentPackController::class, 'destroyOrder'])->name('destroyOrder');
    Route::get('/editSimple/{Id_PackContent}', [ContentPackController::class, 'showFormEditSimple'])->name('showFormEditSimple');
    Route::post('/deleteSimpleContent/{Id_SimpleContent}', [ContentPackController::class, 'destroySimpleContent'])->name('destroySimpleContent');
    Route::post('/destroyPackContent', [ContentPackController::class, 'destroyPackContent'])->name('destroyPackContent');
    Route::get('/show/{Id_Order}', [ContentPackController::class, 'showDetails'])->name('showDetails');
    Route::post('/showDetailsPack', [ContentPackController::class, 'showDetailsPack'])->name('showDetailsPack');
  });
  Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
    Route::post('/storeOrder', [OrderController::class, 'storeOrder'])->name('storeOrder');
    Route::post('/updateOrder', [OrderController::class, 'updateOrder'])->name('updateOrder');
    Route::get('/edit/{Id_Order}', [OrderController::class, 'editOrder'])->name('editOrder');
    Route::post('/updatePackAndCustomer', [OrderController::class, 'updatePackAndCustomer'])->name('updatePackAndCustomer');
  });
  Route::group(['prefix' => 'simples', 'as' => 'simples.'], function () {
    Route::post('/addSimple', [ContentSimpleController::class, 'addSimple'])->name('addSimple');
    Route::post('/storeSimple', [ContentSimpleController::class, 'storeSimple'])->name('storeSimple');
    Route::post('/deleteSimple', [ContentSimpleController::class, 'deleteSimple'])->name('deleteSimple');
    Route::post('/updateSimple', [ContentSimpleController::class, 'updateSimple'])->name('updateSimple');
    Route::post('/updateSimpleContent', [ContentSimpleController::class, 'updateSimpleContent'])->name('updateSimpleContent');
  });

  Route::group(['prefix' => 'orderLocals', 'as' => 'orderLocals.'], function () {
    Route::get('/', [OrderLocalController::class, 'index'])->name('index');
    Route::get('/create', [OrderLocalController::class, 'create'])->name('create');
    Route::post('/store', [OrderLocalController::class, 'store'])->name('store');
    Route::get('/{orderLocal}', [OrderLocalController::class, 'show'])->name('show');
    Route::post('/destroyOrder', [OrderLocalController::class, 'destroyOrder'])->name('destroyOrder');
    Route::post('/destroySimple', [OrderLocalController::class, 'destroySimple'])->name('destroySimple');
    Route::post('/showDetail', [OrderLocalController::class, 'showDetail'])->name('showDetail');
    Route::post('/showSimple', [OrderLocalController::class, 'showSimpleByCustomerType'])->name('showSimple');
    Route::post('/showOrder', [OrderLocalController::class, 'showOrderByCustomerType'])->name('showOrder');
    Route::put('/update/{id}', [OrderLocalController::class, 'update'])->name('update');
    Route::get('/edit/{id}', [OrderLocalController::class, 'edit'])->name('edit');
    Route::get('/edit/{id}/addSimple', [OrderLocalController::class, 'addSimple'])->name('addSimple');
    Route::post('/storeSimple', [OrderLocalController::class, 'storeSimple'])->name('storeSimple');
    Route::delete('/{id}', [OrderLocalController::class, 'destroy'])->name('destroy');
  });

  Route::group(['prefix' => 'wares', 'as' => 'wares.'], function () {
    Route::get('/', [WareController::class, 'index'])->name('index');
    Route::get('/create', [WareController::class, 'create'])->name('create');
    Route::get('show', [WareController::class, 'show'])->name('show');
    Route::post('createWare', [WareController::class, 'createWare'])->name('createWare');
    Route::post('/showDetails', [WareController::class, 'showDetails'])->name('showDetails');
    Route::post('setCellStatus', [WareController::class, 'setCellStatus'])->name('setCellStatus');
  });

  Route::post('/stations/showStation', [StationController::class, 'showStationTypeById'])->name('showStationTypeById');

  Route::post('/productStationLines/create', [ProductStationLineController::class, 'store']);
  Route::post('/productStationLines/update/{id}', [ProductStationLineController::class, 'update']);

  Route::prefix('dispatchs')->group(function () {
    Route::get('/', [DispatchController::class, 'index'])->name('dispatch.index');
    Route::post('getProductStation', [DispatchController::class, 'getProductStation']);
    Route::post('getStatus', [DispatchController::class, 'getStatus']);
    Route::post('store', [DispatchController::class, 'store']);
    Route::post('show', [DispatchController::class, 'show']);
  });
});
