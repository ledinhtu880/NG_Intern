<?php

use App\Http\Controllers\EduProgramController;
use App\Http\Controllers\LessonSubController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('index');

Route::group(['prefix' => 'eduProgram', 'as' => 'eduProgram.'], function () {
    Route::get('', [EduProgramController::class, 'index'])->name('index');
    Route::get('/create', [EduProgramController::class, 'create'])->name('create');
    Route::post('/store', [EduProgramController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [EduProgramController::class, 'edit'])->name('edit');
    Route::post('/update', [EduProgramController::class, 'update'])->name('update');
    Route::delete('{id}', [EduProgramController::class, 'destroy'])->name('destroy');
});
Route::group(['prefix' => 'lessonSub', 'as' => 'lessonSub.'], function () {
    Route::get('', [LessonSubController::class, 'index'])->name('index');
    Route::post('/store', [LessonSubController::class, 'store'])->name('store');
    Route::post('/update', [LessonSubController::class, 'update'])->name('update');
    Route::post('/checkAmount', [LessonSubController::class, 'checkAmount'])->name('checkAmount');
    Route::post('/destroy', [LessonSubController::class, 'destroy'])->name('destroy');
    Route::post('/showSubjects', [LessonSubController::class, 'showSubjects'])->name('showSubjects');
});
