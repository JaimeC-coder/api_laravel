<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductUnitPriceByMeasurementController;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UnitMeasurementController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\Staff;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::ApiResource('roles', RoleController::class);
Route::ApiResource('permissions', PermissionController::class);
//Route::ApiResource('users', UserController::class);

Route::get('dashboard',[HomeController::class, 'index'])->name('dasboard');
Route::get('dashboard1',[HomeController::class, 'dashboardFilter'])->name('dashboardFilter');

Route::prefix('products')->group(function () {
    Route::ApiResource('product', ProductController::class);
    Route::patch('product/{product}/stock', [ProductController::class, 'updateStock']);
    Route::patch('product/{product}/price', [ProductUnitPriceByMeasurementController::class, 'updatePrice']);
    Route::get('product/{productById}/{productUnitPriceId}', [ProductController::class, 'productInformationAll']);
    Route::delete('product/unitprice/{productById}/{productUnitPriceId}' , [ProductUnitPriceByMeasurementController::class, 'destroy']);

});
Route::prefix('categories')->group(function () {
    Route::ApiResource('category', CategoryController::class);
});
Route::prefix('employees')->group(function () {
    Route::ApiResource('', StaffController::class);
    Route::get('/user/{id}', [StaffController::class, 'staffbyUser']);
});
Route::prefix('unitmeasures')->group(function () {
    Route::ApiResource('unitmeasure', UnitMeasurementController::class);
});

Route::prefix('inventories')->group(function () {
   Route::apiResource('inventory', InventoryController::class);
    Route::get('/inventory/transactions/input', [InventoryController::class, 'input']);
    Route::get('/inventory/transactions/ouput', [InventoryController::class, 'ouput']);
});

