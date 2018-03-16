<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('me', 'AuthController@me');
        Route::get('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::resource('categories', 'CategoryController');

        Route::get('users/{id}/period', 'ExpenseController@getPeriod');
        Route::get('users/{id}/expenses/{period}', 'ExpenseController@show');

        Route::post('users/{id}/expenses', 'ExpenseController@store');
        Route::put('users/{id}/expenses', 'ExpenseController@update');
        Route::delete('users/{id}/expenses', 'ExpenseController@destroy');

        // 管理者でしか叩け無いAPI
        Route::group(['middleware' => ['can:admin']], function () {
            Route::get('users', 'UserController@index');
        });
    });
});
