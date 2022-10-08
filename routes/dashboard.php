<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\NewsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth'],
    'as' => 'dashboard.',
    'prefix' => 'dashboard'
], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/force-delete/{category}', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');

    Route::resource('/categories', CategoriesController::class);


    Route::get('/news/trash', [NewsController::class, 'trash'])->name('news.trash');
    Route::put('/news/{news}/restore', [NewsController::class, 'restore'])->name('news.restore');
    Route::delete('/news/force-delete/{news}', [NewsController::class, 'forceDelete'])->name('news.force-delete');

    Route::resource('/news', NewsController::class);

});

