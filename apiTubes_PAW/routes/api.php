<?php

use Illuminate\Http\Request;
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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('paket', 'Api\PaketController@index');
    Route::get('paket/{id}', 'Api\PaketController@show');
    Route::get('kelola', 'Api\KelolaController@index');
    Route::get('kelola/{id}', 'Api\KelolaController@show');
    Route::get('profile', 'Api\AuthController@index');
    Route::get('profile/{id}', 'Api\AuthController@show');
    Route::get('mitra', 'Api\MitraController@index');
    Route::get('mitra/{id}', 'Api\MitraController@show');
    Route::post('kelola', 'Api\KelolaController@store');
    Route::post('paket', 'Api\PaketController@store');
    Route::post('mitra', 'Api\MitraController@store');
    Route::post('profile/{id}', 'Api\AuthController@upload');
    Route::put('paket/{id}', 'Api\PaketController@update');
    Route::put('kelola/{id}', 'Api\KelolaController@update');
    Route::put('mitra/{id}', 'Api\MitraController@update');
    Route::put('profile/{id}', 'Api\AuthController@update');
    Route::delete('paket/{id}', 'Api\PaketController@destroy');
    Route::delete('kelola/{id}', 'Api\KelolaController@destroy');
    Route::delete('mitra/{id}', 'Api\MitraController@destroy');
});
