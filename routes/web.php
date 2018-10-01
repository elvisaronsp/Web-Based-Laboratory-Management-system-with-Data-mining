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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('uploadPhoto',[
    'uses' => 'HomeController@uploadPhoto',
    'as' => 'uploadPhoto'
]);

// route to handle report payments
Route::post('reportPayment', [
    'uses' => 'PaymentController@payWithpaypal',
    'as' => 'reportPayment'
]);
// route to get the status of the transaction
Route::get('paymentStatus', [
    'uses' => 'PaymentController@getStatusReport',
    'as' => 'paymentStatus'
]);
