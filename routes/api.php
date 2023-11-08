<?php

use App\Http\Controllers\putInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/documents/{id}', 'App\Http\Controllers\ClientController@showDocuments');



Route::post('/putInvoice', 'App\Http\Controllers\InvoiceController@store');

Route::get('getInvoice','App\Http\Controllers\InvoiceController@index');//necesita auth ->middleware('auth')

Route::get('getInvoice/{id}','App\Http\Controllers\InvoiceController@show');//necesita auth ->middleware('auth')

Route::put('putInvoiceState/{id}','App\Http\Controllers\InvoiceController@update');

Route::post('login','App\Http\Controllers\ClientController@login');

Route::post('/sendCode','App\Http\Controllers\ClientController@sendCode');
Route::put('resetPassword','App\Http\Controllers\ClientController@putResetPassword');

Route::put('putExpenseState/{id}','App\Http\Controllers\ExpenseController@update');

Route::get('/getExpense','App\Http\Controllers\ExpenseController@index'); //necesita auth

Route::post('/putExpense','App\Http\Controllers\ExpenseController@store'); //necesita auth
Route::get('/getExpense/{id}','App\Http\Controllers\ExpenseController@show'); //necesita auth



Route::get('/getAdvisers','App\Http\Controllers\AdviserController@getAdvisers');
Route::get('/getAdviserClients/{id}','App\Http\Controllers\AdviserController@showClients');

Route::post('/adviser/create','App\Http\Controllers\AdviserController@store');

Route::post('/putUser','App\Http\Controllers\ClientController@store');

Route::post('/putActivateUser','App\Http\Controllers\ClientController@activateUser');

Route::post('/verifyOTP','App\Http\Controllers\ClientController@checkEmailCode');






