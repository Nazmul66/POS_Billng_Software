<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UnitController;
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


    //______ Brand _____//
    Route::resource('/brands', BrandsController::class)->names('brand');
    Route::get('/brand-data', [BrandsController::class, 'getData'])->name('brand-data');
    Route::post('/change-brand-status', [BrandsController::class, 'changeBrandStatus'])->name('brand.status');
    Route::get('/brands/view/{id}', [BrandsController::class, 'brandView'])->name('brand.view');


    //______ Units _____//
    Route::resource('/units', UnitController::class)->names('unit');
    Route::get('/unit-data', [UnitController::class, 'getData'])->name('unit-data');
    Route::post('/unit/status', [UnitController::class, 'changeUnitStatus'])->name('unit.status');
    Route::get('/units/view/{id}', [UnitController::class, 'unitView'])->name('unit.view');

});