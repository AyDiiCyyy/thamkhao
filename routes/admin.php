<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryProductController;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::prefix('products')
            ->controller(ProductController::class)
            ->name('products.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::post('/{id}/update', 'update')->name('update');
                Route::delete('/{id}/delete', 'delete')->name('delete');
                Route::post('/change-order', 'changeOrder')->name('changeOrder');
                Route::post('/change-hot', 'changeHot')->name('changeHot');
                Route::post('/change-active', 'changeActive')->name('changeActive');
                Route::delete('/destroyImage/{id}', 'destroyImage')->name('destroyImage');
            });

        Route::prefix('categoryProducts')
            ->controller(CategoryProductController::class)
            ->name('categoryProducts.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::post('/{id}/update', 'update')->name('update');
                Route::delete('/{id}/delete', 'delete')->name('delete');
                Route::post('/change-order', 'changeOrder')->name('changeOrder');
                Route::post('/change-hot', 'changeHot')->name('changeHot');
                Route::post('/change-active', 'changeActive')->name('changeActive');
            });


    });
