<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::post('/customer', 'CustomerController@create');

Route::group(['middleware'=>'auth'], function (){

    Route::get('/api', function () {
        return view('api');
    });

    Route::get('/transactions', 'TransactionController@index');
    Route::get('/transactions/filter', 'TransactionController@getTransactionsPaginateFiltered');

});





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

