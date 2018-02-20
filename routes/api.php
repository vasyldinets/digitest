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

//All API requests must have token
Route::middleware(['auth:api', 'middleware' => 'api', 'middleware' => 'cache'])->group(function () {

    Route::post('/customer', 'CustomerController@store');
    Route::post('/transaction', 'TransactionController@store');

    Route::get('/transaction/{customer}/{transaction}', 'TransactionController@show');
    Route::get('/transaction/filter', 'TransactionController@getFilteredTransactions');

    Route::patch('/transaction/{transaction}', 'TransactionController@update');

    Route::delete('/transaction/{transaction}', 'TransactionController@destroy');

});