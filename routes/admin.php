<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BillerController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\WarehouseController;
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


    //______ Customers _____//
    Route::resource('/customers', CustomerController::class)->names('customer');
    Route::get('/customer-data', [CustomerController::class, 'getData'])->name('customer-data');
    Route::post('/customer/status', [CustomerController::class, 'changeCustomerStatus'])->name('customer.status');
    Route::get('/customers/view/{id}', [CustomerController::class, 'customerView'])->name('customer.view');


    //______ Bills _____//
    Route::resource('/bills', BillerController::class)->names('bill');
    Route::get('/bill-data', [BillerController::class, 'getData'])->name('bill-data');
    Route::post('/bill/status', [BillerController::class, 'changeBillStatus'])->name('bill.status');
    Route::get('/bills/view/{id}', [BillerController::class, 'billView'])->name('bill.view');


    //______ Supplier _____//
    Route::resource('/suppliers', SupplierController::class)->names('supplier');
    Route::get('/supplier-data', [SupplierController::class, 'getData'])->name('supplier-data');
    Route::post('/supplier/status', [SupplierController::class, 'changeSupplierStatus'])->name('supplier.status');
    Route::get('/suppliers/view/{id}', [SupplierController::class, 'supplierView'])->name('supplier.view');


    //______ Warehouse _____//
    Route::resource('/warehouses', WarehouseController::class)->names('warehouse');
    Route::get('/warehouse-data', [WarehouseController::class, 'getData'])->name('warehouse-data');
    Route::post('/warehouse/status', [WarehouseController::class, 'changeWarehouseStatus'])->name('warehouse.status');
    Route::get('/warehouses/view/{id}', [WarehouseController::class, 'warehouseView'])->name('warehouse.view');

});