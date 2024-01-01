<?php

use App\Http\Controllers\API\Admin\Product\ProductImageController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\Account\AddressController;
use App\Http\Controllers\API\User\Account\FavoriteController;
use App\Http\Controllers\API\User\Account\ShoppingCartController;
use App\Http\Controllers\API\User\Category\CategoryController;
use App\Http\Controllers\API\User\Product\CommentController;
use App\Http\Controllers\API\User\Product\ProductController;
use App\Http\Controllers\API\User\Account\AccountController;
use App\Http\Controllers\API\User\Order\OrderController;
use Illuminate\Support\Facades\Route;


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
        //user panel account information
        Route::get('information',[AccountController::class,'index']);
        Route::put('information',[AccountController::class,'update']);
        //user image change
        Route::post('image',[AccountController::class,'imageChange']);
        //user files
        Route::post('files',[AccountController::class,'fileUpload']);
        Route::delete('files/{fileId}',[AccountController::class,'fileDestroy']);
        // user addresses managment
        Route::resource('address',AddressController::class);
        //shopping cart
        Route::resource('shopping-cart',ShoppingCartController::class);
        Route::get('shopping-cart/amount-increment/{id}',[ShoppingCartController::class,'amountIncrement']);
        Route::get('shopping-cart/amount-decrement/{id}',[ShoppingCartController::class,'amountDecrement']);
        //favorites
        Route::get('favorites',[FavoriteController::class,'index']);
        Route::post('favorites',[FavoriteController::class,'store']);
        Route::delete('favorites/{id}',[FavoriteController::class,'destroy']);

        Route::get('orders',[OrderController::class,'index']);
        Route::post('orders',[OrderController::class,'store']);
        Route::get('orders/{orderId}',[OrderController::class,'show']);

    });
    Route::post('products/comments',[CommentController::class,'store']);
    //logged out
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'auth/admin','middleware' => ['auth:sanctum','admin']],function (){
    //admin test
    Route::get('test',function (){
       return response()->json(['message' => 'admin test success']);
    });
    //admin account
    Route::get('account',[\App\Http\Controllers\API\Admin\Account\AccountController::class,'index']);
    Route::put('account',[\App\Http\Controllers\API\Admin\Account\AccountController::class,'update']);
    Route::post('account/image',[\App\Http\Controllers\API\Admin\Account\AccountController::class,'imageChange']);
    //users managment
    Route::resource('users', \App\Http\Controllers\API\Admin\User\UserController::class);
    // product comments list,status update,delete
    Route::resource('products/comments',\App\Http\Controllers\API\Admin\Product\CommentController::class);
    //admin panel products managment
    Route::resource('products',\App\Http\Controllers\API\Admin\Product\ProductController::class);
    //admin panel product images
    Route::post('products/image',[ProductImageController::class,'store']);
    Route::delete('products/image/{id}',[ProductImageController::class,'destroy']);
    //admin categories managment
    Route::resource('categories',\App\Http\Controllers\API\Admin\Category\CategoryController::class);
    //admin products comments
    Route::get('products/{id}/comments',[\App\Http\Controllers\API\Admin\Product\CommentController::class,'getProductComments']);
    //admin orders
    Route::get('orders/{type?}',[\App\Http\Controllers\API\Admin\Order\OrderController::class,'index']);
    Route::get('orders/{orderId}',[\App\Http\Controllers\API\Admin\Order\OrderController::class,'show']);
    Route::put('orders/{orderId}',[\App\Http\Controllers\API\Admin\Order\OrderController::class,'update']);

});
//user panel categories
Route::get('categories',[CategoryController::class,'index']);
//user panel products
Route::get('products',[ProductController::class,'index']);
Route::get('products/{product_id}',[ProductController::class,'show']);
//user panel products comments
Route::get('products/{id}/comments',[CommentController::class,'index']);


