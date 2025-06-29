<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::prefix('')->controller(AuthController::class)->group(function () {
        Route::get('/', 'login')->name('login');
        Route::post('login', 'authenticate')->name('login.auth');
    });
});
Route::prefix('')->controller(AuthController::class)->group(function () {
    Route::get('dashboard', 'dashboard')->name('dashboard');
    Route::post('branch/update', 'updateBranch')->name('user.branch.update');
});
Route::middleware(['web', 'auth', 'branch'])->group(function () {
    Route::prefix('ajax')->controller(AjaxController::class)->group(function () {
        Route::get('material/details/{pid}', 'getMaterialDetails')->name('get.material.details');
        Route::get('production/details/{pid}', 'getProductionDetails')->name('get.production.details');
    });
    Route::prefix('')->controller(HelperController::class)->group(function () {
        Route::get('item', 'items')->name('item.register');
        Route::post('production/material/save', 'saveProductionMaterial')->name('production.material.save');
        Route::post('production/parts/save', 'saveProductionParts')->name('production.parts.save');
        Route::post('production/decom/save', 'saveProductionDecom')->name('production.decom.save');
    });
    Route::prefix('')->controller(AuthController::class)->group(function () {
        Route::get('logout', 'logout')->name('logout');
    });
    Route::prefix('role')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('role.register');
        Route::get('create', 'create')->name('role.create');
        Route::post('create', 'store')->name('role.save');
        Route::get('edit/{id}', 'edit')->name('role.edit');
        Route::post('edit/{id}', 'update')->name('role.update');
        Route::get('delete/{id}', 'destroy')->name('role.delete');
    });
    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('user.register');
        Route::get('create', 'create')->name('user.create');
        Route::post('create', 'store')->name('user.save');
        Route::get('edit/{id}', 'edit')->name('user.edit');
        Route::post('edit/{id}', 'update')->name('user.update');
        Route::get('delete/{id}', 'destroy')->name('user.delete');
        Route::get('restore/{id}', 'restore')->name('user.restore');
    });
    Route::prefix('branch')->controller(BranchController::class)->group(function () {
        Route::get('/', 'index')->name('branch.register');
        Route::get('create', 'create')->name('branch.create');
        Route::post('create', 'store')->name('branch.save');
        Route::get('edit/{id}', 'edit')->name('branch.edit');
        Route::post('edit/{id}', 'update')->name('branch.update');
        Route::get('delete/{id}', 'destroy')->name('branch.delete');
        Route::get('restore/{id}', 'restore')->name('branch.restore');
    });
    Route::prefix('entity')->controller(EntityController::class)->group(function () {
        Route::get('/', 'index')->name('entity.register');
        Route::get('create', 'create')->name('entity.create');
        Route::post('create', 'store')->name('entity.save');
        Route::get('edit/{id}', 'edit')->name('entity.edit');
        Route::post('edit/{id}', 'update')->name('entity.update');
        Route::get('delete/{id}', 'destroy')->name('entity.delete');
        Route::get('restore/{id}', 'restore')->name('entity.restore');
    });
    Route::prefix('purchase')->controller(PurchaseController::class)->group(function () {
        Route::get('/', 'index')->name('purchase.register');
        Route::get('create', 'create')->name('purchase.create');
        Route::post('create', 'store')->name('purchase.save');
        Route::get('edit/{id}', 'edit')->name('purchase.edit');
        Route::post('edit/{id}', 'update')->name('purchase.update');
        Route::get('delete/{id}', 'destroy')->name('purchase.delete');
        Route::get('restore/{id}', 'restore')->name('purchase.restore');
    });

    Route::prefix('production')->controller(ProductionController::class)->group(function () {
        Route::get('/{type}/{stype}', 'index')->name('production.register');
        Route::get('create/{type}/{stype}', 'create')->name('production.create');
        Route::post('create/{type}/{stype}', 'store')->name('production.save');
        Route::get('edit/{type}/{id}/{stype}', 'edit')->name('production.edit');
        Route::post('edit/{id}/{type}/{stype}', 'update')->name('production.update');
        Route::get('delete/{id}/{type}/{stype}', 'destroy')->name('production.delete');
        Route::get('restore/{id}', 'restore')->name('production.restore');
    });

    Route::prefix('transfer')->controller(TransferController::class)->group(function () {
        Route::get('/{type}', 'index')->name('transfer.register');
        Route::get('create/{type}', 'create')->name('transfer.create');
        Route::post('create/{type}', 'store')->name('transfer.save');
        Route::get('edit/{id}', 'edit')->name('transfer.edit');
        Route::post('edit/{id}', 'update')->name('transfer.update');
        Route::get('delete/{id}', 'destroy')->name('transfer.delete');
        Route::get('restore/{id}', 'restore')->name('transfer.restore');
    });
});
