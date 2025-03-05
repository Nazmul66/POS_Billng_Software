<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["as" => 'admin.',"prefix" => '/admin'], function () {

    //__ Admin __//
    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', "index")->name('dashboard');
    });


    //______ Category _____//
    Route::resource('/categories', CategoryController::class)->names('category');
    Route::get('/category-data', [CategoryController::class, 'getData'])->name('category-data');
    Route::post('/categories/status', [CategoryController::class, 'changeCategoryStatus'])->name('category.status');
    Route::get('/categories/view/{id}', [CategoryController::class, 'CategoryView'])->name('category.view');


    //______ Subcategory _____//
    Route::resource('/subcategories', SubcategoryController::class)->names('subcategory');
    Route::get('/subcategory-data', [SubcategoryController::class, 'getData'])->name('subcategory-data');
    Route::post('/subcategory/status', [SubcategoryController::class, 'changeSubCategoryStatus'])->name('subcategory.status');
    Route::get('/subcategories/view/{id}', [SubcategoryController::class, 'subCategoryView'])->name('subcategory.view');

});