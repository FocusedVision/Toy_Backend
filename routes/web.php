<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index');

Route::get('/{page:slug}', 'IndexController@getPage')->name('page.index');

Route::get('/away/{link}', 'IndexController@awayProxy')->name('away');

Route::get('/wishlist/{encoded_data}', 'WishlistController@show')->name('wishlist.show');

Route::get('/wishlist/{encoded_data}', 'WishlistController@show')->name('wishlist.show');
Route::get('/.well-known/apple-app-site-association', 'DeepLinkController@apple');
Route::get('/.well-known/assetlinks.json', 'DeepLinkController@android');