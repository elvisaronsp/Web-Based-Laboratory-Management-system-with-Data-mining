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

//route to add blood suger
Route::post('bloodSuger', [
    'uses' => 'ReportController@bloodSuger',
    'as' => 'bloodSuger'
]);

//route to add lipis
Route::post('lipid', [
    'uses' => 'ReportController@lipid',
    'as' => 'lipid'
]);

//route to add full blood count
Route::post('fbc', [
    'uses' => 'ReportController@fbc',
    'as' => 'fbc'
]);

Route::post('delfbc', [
    'uses' => 'ReportController@delfbc',
    'as' => 'delfbc'
]);
Route::post('delbs', [
    'uses' => 'ReportController@delbs',
    'as' => 'delbs'
]);
Route::post('delserum', [
    'uses' => 'ReportController@delserum',
    'as' => 'delserum'
]);

Route::post('dellf', [
    'uses' => 'ReportController@dellf',
    'as' => 'dellf'
]);
Route::post('dellp', [
    'uses' => 'ReportController@dellp',
    'as' => 'dellp'
]);



//route to add Liver Function
Route::post('liver', [
    'uses' => 'ReportController@liver',
    'as' => 'liver'
]);

Route::post('slp', [
    'uses' => 'ReportController@slp',
    'as' => 'slp'
]);

//route to add sample tranfer
Route::post('sample', [
    'uses' => 'SampleController@addSample',
    'as' => 'sample'
]);
//route to delete sample tranfer
Route::post('deleteSample', [
    'uses' => 'SampleController@deleteSample',
    'as' => 'deleteSample'
]);


Route::post('addPatient', [
    'uses' => 'ReportController@addPatient',
    'as' => 'addPatient'
]);

Route::post('addMLT', [
    'uses' => 'EmployeeController@addMLT',
    'as' => 'addMLT'
]);

Route::post('addEmployee', [
    'uses' => 'EmployeeController@addEmployee',
    'as' => 'addEmployee'
]);

Route::post('deleteEmployee', [
    'uses' => 'EmployeeController@deleteEmployee',
    'as' => 'deleteEmployee'
]);

Route::post('updateEmployee', [
    'uses' => 'EmployeeController@updateEmployee',
    'as' => 'updateEmployee'
]);

