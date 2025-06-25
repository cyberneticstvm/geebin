<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\RoleController;
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
        Route::post('validate/inventory', 'validateInventory')->name('validate.inventory');
        Route::get('production/output', 'getProductionOutput')->name('get.production.output');
        Route::post('validate/formula', 'validateFormula')->name('validate.formula');
    });
    Route::prefix('')->controller(HelperController::class)->group(function () {
        Route::get('formula', 'materialFormula')->name('formula');
        Route::get('transfer/pending/approval', 'pendingTransferRegister')->name('transfer.pending.approval.register');
        Route::post('transfer/pending/approval', 'pendingTransferStatusUpdate')->name('transfer.pending.status.update');
        Route::post('production/ouput/update', 'updateProductionOutput')->name('production.output.update');
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
});
