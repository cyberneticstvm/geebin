<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::prefix('')->controller(AuthController::class)->group(function () {
        Route::get('/', 'login')->name('login');
        Route::post('login', 'authenticate')->name('login.auth');
    });
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::prefix('')->controller(HelperController::class)->group(function () {
        Route::get('formula', 'materialFormula')->name('material.formula');
    });
    Route::prefix('')->controller(AuthController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::post('branch/update', 'updateBranch')->name('user.branch.update');
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
    Route::prefix('material')->controller(MaterialController::class)->group(function () {
        Route::get('/', 'index')->name('material.register');
        Route::get('create', 'create')->name('material.create');
        Route::post('create', 'store')->name('material.save');
        Route::get('edit/{id}', 'edit')->name('material.edit');
        Route::post('edit/{id}', 'update')->name('material.update');
        Route::get('delete/{id}', 'destroy')->name('material.delete');
        Route::get('restore/{id}', 'restore')->name('material.restore');
    });
    Route::prefix('company')->controller(CompanyController::class)->group(function () {
        Route::get('/', 'index')->name('company.register');
        Route::get('create', 'create')->name('company.create');
        Route::post('create', 'store')->name('company.save');
        Route::get('edit/{id}', 'edit')->name('company.edit');
        Route::post('edit/{id}', 'update')->name('company.update');
        Route::get('delete/{id}', 'destroy')->name('company.delete');
        Route::get('restore/{id}', 'restore')->name('company.restore');
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
