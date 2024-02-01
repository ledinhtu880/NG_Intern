<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\WareController;
use App\Http\Controllers\DispatchController;
use App\Http\Controllers\OrderLocalController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\ProductStationLineController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\InfoOrderLocalController;
use App\Http\Controllers\InforCustomerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'checklogin'])->name('checkLogin');
Route::get('logout',  [AuthController::class, 'logout'])->name('logout');

Route::middleware('checklogin')->group(function () {
  Route::get('', [HomeController::class, 'index'])->name('index');
  Route::resource('rawMaterials', RawMaterialController::class);
  Route::resource('customers', CustomerController::class);
  Route::resource('stations', StationController::class);

  Route::post('getImgByStationType', [StationController::class, 'getImgByStationType'])->name('getImgByStationType');
  Route::resource('productStationLines', ProductStationLineController::class);
  Route::resource('users', UserController::class);

  Route::group(['prefix' => 'rawMaterials', 'as' => 'rawMaterials.'], function () {
    Route::post('showMaterials', [RawMaterialController::class, 'showRawMaterialsByType'])->name('showMaterials');
    Route::post('showUnit', [RawMaterialController::class, 'showUnit'])->name('showUnit');
  });
  Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::post('showRoles', [UserController::class, 'showRoles'])->name('showRoles');
    Route::post('destroyUsers', [UserController::class, 'destroyUsers'])->name('destroyUsers');
    Route::post('searchUsers', [UserController::class, 'searchUsers'])->name('searchUsers');
  });
  Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
    Route::post('store', [OrderController::class, 'storeOrder'])->name('store');
    Route::post('update', [OrderController::class, 'updateOrder'])->name('update');
    Route::post('checkCustomer', [OrderController::class, 'checkCustomer'])->name('checkCustomer');

    Route::group(['prefix' => 'simples', 'as' => 'simples.'], function () {
      Route::get('', [OrderController::class, 'indexSimples'])->name('index');
      Route::post('redirectSimples', [OrderController::class, 'redirectToSimples'])->name('redirectSimples');
      Route::get('show/{id}', [OrderController::class, 'showSimples'])->name('show');
      Route::get('createSimple', [OrderController::class, 'createSimples'])->name('create');
      Route::post('store', [OrderController::class, 'storeSimples'])->name('store');
      Route::get('edit/{id}', [OrderController::class, 'editSimples'])->name('edit');
      Route::post('update', [OrderController::class, 'updateSimples'])->name('update');
      Route::delete('{id}', [OrderController::class, 'destroySimples'])->name('destroy');
      Route::get('getSimplesInWarehouse', [OrderController::class, 'getSimplesInWarehouse'])->name('getSimplesInWarehouse');
      Route::post('getSimple', [OrderController::class, 'getSimple'])->name('getSimple');
      Route::post('addSimple', [OrderController::class, 'addSimple'])->name('addSimple');
      Route::post('deleteSimple', [OrderController::class, 'deleteSimples'])->name('deleteSimple');
      Route::post('destroySimplesWhenBack', [OrderController::class, 'destroySimplesWhenBack'])->name('destroySimplesWhenBack');
      Route::post('checkSimpleInProcess', [OrderController::class, 'checkSimpleInProcess'])->name('checkSimpleInProcess');
    });

    Route::group(['prefix' => 'packs', 'as' => 'packs.'], function () {
      Route::get('', [OrderController::class, 'indexPacks'])->name('index');
      Route::get('show/{id}', [OrderController::class, 'showPacks'])->name('show');
      Route::get('create', [OrderController::class, 'createPacks'])->name('create');
      Route::post('store', [OrderController::class, 'storePacks'])->name('store');
      Route::get('edit/{id}', [OrderController::class, 'editPacks'])->name('edit');
      Route::post('update', [OrderController::class, 'updatePacks'])->name('updatePacks');
      Route::delete('destroy/{id}', [OrderController::class, 'destroyPacks'])->name('destroy');  /* Xóa đơn gói hàng */
      Route::get('createSimpleToPack', [OrderController::class, 'createSimpleToPack'])->name('createSimpleToPack');
      Route::post('addSimpleToPack', [OrderController::class, 'addSimpleToPack'])->name('addSimpleToPack');
      Route::get('editSimpleInPack/{id}', [OrderController::class, 'editSimpleInPack'])->name('editSimpleInPack');
      Route::post('storeDetail', [OrderController::class, 'storeDetailContentSimpleOfPack'])->name('storeDetailContentSimpleOfPack');
      Route::post('updateSimpleInPack', [OrderController::class, 'updateSimpleInPack'])->name('updateSimpleInPack');
      Route::post('deletePacks', [OrderController::class, 'deletePacks'])->name('deletePacks');  /* Sử dụng Ajax để xóa gói hàng */
      Route::post('destroySimpleInPack/{id}', [OrderController::class, 'destroySimpleInPack'])->name('destroySimpleInPack');
      Route::post('destroyContentPack', [OrderController::class, 'destroyContentPack'])->name('destroyContentPack');
      Route::post('showPacksDetails', [OrderController::class, 'showPacksDetails'])->name('showPacksDetails');
      Route::get('getPacksInWarehouse', [OrderController::class, 'getPacksInWarehouse'])->name('getPacksInWarehouse');
      Route::post('destroyPacksWhenBack', [OrderController::class, 'destroyPacksWhenBack'])->name('destroyPacksWhenBack');
      Route::post('getPack', [OrderController::class, 'getPack'])->name('getPack');
    });
  });

  Route::group(['prefix' => 'orderLocals', 'as' => 'orderLocals.'], function () {
    Route::group(['prefix' => 'makes', 'as' => 'makes.'], function () {
      Route::get('', [OrderLocalController::class, 'indexMakes'])->name('index');
      Route::get('create', [OrderLocalController::class, 'createMakes'])->name('create');
      Route::post('store', [OrderLocalController::class, 'storeMakes'])->name('store');
      Route::get('{orderLocal}', [OrderLocalController::class, 'showMakes'])->name('show');
      Route::post('destroyOrderMakes', [OrderLocalController::class, 'destroyOrderMakes'])->name('destroyOrderMakes');
      Route::post('destroySimple', [OrderLocalController::class, 'destroySimple'])->name('destroySimple');
      Route::post('showDetail', [OrderLocalController::class, 'showDetail'])->name('showDetail');
      Route::post('showSimple', [OrderLocalController::class, 'showSimpleByCustomerType'])->name('showSimple');
      Route::post('showOrder', [OrderLocalController::class, 'showOrderByCustomerType'])->name('showOrder');
      Route::put('update/{id}', [OrderLocalController::class, 'updateMakes'])->name('update');
      Route::get('edit/{id}', [OrderLocalController::class, 'editMakes'])->name('edit');
      Route::get('edit/{id}/addSimple', [OrderLocalController::class, 'addSimple'])->name('addSimple');
      Route::post('storeSimple', [OrderLocalController::class, 'storeSimple'])->name('storeSimple');
      Route::delete('{id}', [OrderLocalController::class, 'destroyMakes'])->name('destroy');
    });

    Route::group(['prefix' => 'packs', 'as' => 'packs.'], function () {
      Route::get('', [OrderLocalController::class, 'indexPacks'])->name('index');
      Route::get('create', [OrderLocalController::class, 'createPacks'])->name('create');
      Route::post('showSimple', [OrderLocalController::class, 'showSimpleByCustomerTypePacks'])->name('showSimpleByCustomerType');
      Route::post('store', [OrderLocalController::class, 'storePacks'])->name('store');
      Route::post('showOrderLocal', [OrderLocalController::class, 'showOrderLocal'])->name('showOrderLocal');
      Route::post('delete', [OrderLocalController::class, 'deletePacks'])->name('delete');
      Route::post('show', [OrderLocalController::class, 'showPacks'])->name('show');
      Route::delete('deleteOrderLocal/{id}', [OrderLocalController::class, 'deleteOrderLocal'])->name('deleteOrderLocal');
      Route::get('showDetails/{id}', [OrderLocalController::class, 'showDetailsPacks'])->name('showDetails');
      Route::get('showEdit/{id}', [OrderLocalController::class, 'showEditPacks'])->name('showEdit');
      Route::post('showSimpleInPack', [OrderLocalController::class, 'showSimpleInPack'])->name('showSimpleInPack');
      Route::put('update/{id}', [OrderLocalController::class, 'updatePacks'])->name('update');
      Route::post('destroyPack', [OrderLocalController::class, 'destroyPack'])->name('destroyPack');
    });

    Route::group(['prefix' => 'expeditions', 'as' => 'expeditions.'], function () {
      Route::get('', [OrderLocalController::class, 'indexExpedition'])->name('index');
      Route::get('create', [OrderLocalController::class, 'createExpedition'])->name('create');
      Route::post('getOrder', [OrderLocalController::class, 'showOrderByStation']);
      Route::post('store', [OrderLocalController::class, 'storeExpedition']);
      Route::get('edit/{id}', [OrderLocalController::class, 'editOrderExpedition'])->name('edit');
      Route::put('update/{id}', [OrderLocalController::class, 'updateOrderExpedition'])->name('update');
      Route::post('showDetails', [OrderLocalController::class, 'showOrderExpeditionDetails']);
      Route::get('show/{id}', [OrderLocalController::class, 'showExpeditions'])->name('show');
      Route::post('delete', [OrderLocalController::class, 'deleteOrderExpedition']);
      Route::delete('deleteIndex/{id}', [OrderLocalController::class, 'deleteOrderExpeditionByIndex'])->name('destroy');
    });
  });

  Route::group(['prefix' => 'wares', 'as' => 'wares.'], function () {
    Route::get('', [WareController::class, 'index'])->name('index');
    Route::get('create', [WareController::class, 'create'])->name('create');
    Route::get('show', [WareController::class, 'show'])->name('show');
    Route::post('createWare', [WareController::class, 'createWare'])->name('createWare');
    Route::post('showDetails', [WareController::class, 'showDetails'])->name('showDetails');
    Route::post('setCellStatus', [WareController::class, 'setCellStatus'])->name('setCellStatus');
    Route::post('showSimple', [WareController::class, 'showSimple'])->name('showSimple');
    Route::post('showPack', [WareController::class, 'showPack'])->name('showPack');
    Route::post('showSimpleInPack', [WareController::class, 'showSimpleInPack'])->name('showSimpleInPack');
    Route::post('freeContentSimple', [WareController::class, 'freeContentSimple'])->name('freeContentSimple');
    Route::post('checkAmountContentSimple', [WareController::class, 'checkAmountContentSimple'])->name('checkAmountContentSimple');
    Route::post('disabledContentSimple', [WareController::class, 'disabledContentSimple'])->name('disabledContentSimple');
    Route::post('freeContentPack', [WareController::class, 'freeContentPack'])->name('freeContentPack');
    Route::post('checkAmountContentPack', [WareController::class, 'checkAmountContentPack'])->name('checkAmountContentPack');
    Route::post('disabledContentPack', [WareController::class, 'disabledContentPack'])->name('disabledContentPack');
  });

  Route::post('stations/showStation', [StationController::class, 'showStationTypeById'])->name('showStationTypeById');

  Route::post('productStationLines/create', [ProductStationLineController::class, 'store']);
  Route::post('productStationLines/update/{id}', [ProductStationLineController::class, 'update'])->name('productStationLines.update');

  Route::prefix('dispatchs')->group(function () {
    Route::get('', [DispatchController::class, 'index'])->name('dispatch.index');
    Route::post('getProductStation', [DispatchController::class, 'getProductStation']);
    Route::post('getProductStationByRaw', [DispatchController::class, 'getProductStationByRaw']);
    Route::post('showOrderByRawType', [DispatchController::class, 'showOrderByRawType']);
    Route::post('showOrderByItemType', [DispatchController::class, 'showOrderByItemType']);
    Route::post('getStatus', [DispatchController::class, 'getStatus']);
    Route::post('store', [DispatchController::class, 'store']);
    Route::post('show', [DispatchController::class, 'show']);
  });

  Route::group(['prefix' => 'tracking', 'as' => 'tracking.'], function () {
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
      Route::get('', [TrackingController::class, 'index'])->name('index');
      Route::post('ShowOrderByDate', [TrackingController::class, 'ShowOrderByDate'])->name('ShowOrderByDate');
      Route::get('showPacks/{id}', [TrackingController::class, 'showPacks'])->name('showPacks');
      Route::get('showSimples/{id}', [TrackingController::class, 'showSimples'])->name('showSimples');
      Route::get('showDetailsSimple/{id}', [TrackingController::class, 'showDetailsSimple'])->name('showDetailsSimple');
    });

    Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
      Route::get('', [InforCustomerController::class, 'index'])->name('index');
      Route::post('getInformation', [InforCustomerController::class, 'getInformation'])->name('getInformation');
      Route::get('showPacks/{id}', [InforCustomerController::class, 'showPacks'])->name('showPacks');
      Route::get('showSimples/{id}', [InforCustomerController::class, 'showSimples'])->name('showSimples');
    });

    Route::group(['prefix' => 'orderlocals', 'as' => 'orderlocals.'], function () {
      Route::get('', [InfoOrderLocalController::class, 'index'])->name('index');
      Route::post('', [InfoOrderLocalController::class, 'getInfoOrderLocal']);
      Route::get('showSimples/{id}', [InfoOrderLocalController::class, 'showSimples'])->name('showSimples');
      Route::get('showPacks/{id}', [InfoOrderLocalController::class, 'showPacks'])->name('showPacks');;
      Route::post('detailSimpleOfPack', [InfoOrderLocalController::class, 'detailSimpleOfPack'])->name('detailSimpleOfPack');
      Route::get('/showDetailsSimple/{id}', [InfoOrderLocalController::class, 'showDetailsSimple'])->name('showDetailsSimple');
    });
  });

  Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
    Route::get('', [RoleController::class, 'index'])->name('index');
    Route::post('store', [RoleController::class, 'store']);
    Route::post('showRoleByUser', [RoleController::class, 'showRoleByUser']);
  });

  Route::post('getUser', [UserController::class, 'getUser'])->name('getUser');
  Route::post('/getImgByStationType', [StationController::class, 'getImgByStationType'])->name('getImgByStationType');
});
