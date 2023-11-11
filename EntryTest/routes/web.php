<?php

use App\Http\Controllers\ChiTietDonNhapController;
use App\Http\Controllers\DonNhapHangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MatHangController;
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
Route::resource('/donhang', DonNhapHangController::class)->except('index');
Route::post('/showItemsInCategory', [MatHangController::class, 'showItemsInCategory']);
Route::post('/showDetailsItem', [MatHangController::class, 'showDetailsItem']);
Route::post('/add-data', [ChiTietDonNhapController::class, 'addData'])->name('add-data');
Route::post('/update-data', [ChiTietDonNhapController::class, 'updateData'])->name('update-data');
Route::delete('/delete-data', [ChiTietDonNhapController::class, 'deleteData'])->name('delete-data');
