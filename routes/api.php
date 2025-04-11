<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/auth')->controller('AuthController')->name('auth.')->group(function () {
    Route::post('/session', 'createSessionToken')->name('session');
    Route::post('/token', 'createAccessToken')->name('token');
});

Route::prefix('/user')->controller('UserController')->middleware('auth:api')->name('user.')->group(function () {
    Route::get('/', 'getCurrentUser')->name('index');
    Route::post('/', 'updateCurrentUser')->name('update');

    Route::prefix('/products')->name('products.')->group(function () {
        Route::get('/', 'getProducts')->name('index');
        Route::post('/{product}', 'addProduct')->name('create');
        Route::delete('/{product}', 'deleteProduct')->name('delete');
    });

    Route::prefix('/avatars')->name('avatars.')->group(function () {
        Route::get('/', 'getAvatars')->name('index');
    });

    Route::prefix('/notification') ->name('notification')->group(function(){
        Route::get('/', 'getNotification')->name('getNotification');
        Route::post('/', 'updateNotification')->name('updateNotification');

    });

    Route::prefix('/push-tokens')->name('push-tokens.')->group(function () {
        Route::post('/', 'createPushToken')->name('create');
    });
});

Route::prefix('/products')->controller('ProductController')->middleware('auth:api')->name('products.')->group(function () {
    Route::get('/', 'getProducts')->name('index');

    Route::prefix('/{product}')->group(function () {
        Route::get('/', 'getProduct')->name('show');

        Route::prefix('/likes')->name('likes.')->group(function () {
            Route::post('/', 'addProductLike')->name('create');
            Route::delete('/', 'deleteProductLike')->name('delete');
        });

        Route::prefix('/events')->name('events.')->group(function () {
            Route::post('/', 'createProductEvent')->name('create');
        });

        Route::prefix('/info')->name('info.')->group(function () {
            Route::get('/', 'getProductInfo')->name('index')->withoutMiddleware('auth:api');
        });
    });
});
