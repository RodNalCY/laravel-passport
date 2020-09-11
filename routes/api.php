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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([], function () {
    // APIS Libres

    Route::post('index', 'UserController@index');
    Route::post('inicio', 'UserController@inicio');

    Route::post('login', 'UserController@login');
    Route::post('registro', 'UserController@registro');
    Route::post('signup', 'UserController@signup');

    Route::post('reniec', 'UserController@reniec');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        // APIS que necesitan el Bearer Token
        Route::get('logout', 'UserController@logout');
        Route::get('users', 'UserController@users');

    });
});
