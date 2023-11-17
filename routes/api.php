<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\Account\AddressController;
use App\Http\Controllers\API\User\Product\ProductController;
use App\Http\Controllers\API\User\Category\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});


Route::group(['prefix' => 'auth','middleware' => ['auth:sanctum','user']],function (){
    //test route
    Route::get('test',function (){
        return response()->json(['message' => 'user test success'],201);
    });
    //accounts
    Route::prefix('account')->group(function (){
        Route::resource('address',AddressController::class);
    });

    //logged out
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'auth','middleware' => ['auth:sanctum','admin']],function (){
    Route::get('admin/test',function (){
       return response()->json(['message' => 'admin test success']);
    });
});
Route::resource('products',ProductController::class);
Route::resource('categories',CategoryController::class);
