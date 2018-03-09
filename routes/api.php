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
        Route::resource('expenses', 'ExpenseController');

        Route::get('period/list', 'ExpenseController@getPeriodList');
        Route::post('expense/list', 'ExpenseController@getExpenseList');

        Route::put('expenses/update', 'ExpenseController@update');
        Route::delete('expenses', 'ExpenseController@destroy');
    });
});
