<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdviserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmailCodeController;
use App\Http\Controllers\putInvoice;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/',function(){
    return redirect('/home');
})->middleware(['auth','verified']);
Route::get('/home',function(){
    if(Auth::check()&&Auth::user()->is_super_admin===1){ //si es el super admin devuelve la vista del super admin, sino devuelve la del asesor
        return redirect('/backoffice');
    }
    else if(Auth::check()&&Auth::user()->is_super_admin===0){
        return redirect('/clients/list');
    }
    
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');



Route::get('/backoffice', [AdviserController::class, 'index'])->name('backoffice')->middleware(['auth', 'verified','type']);


Route::post('/advisers', [AdviserController::class, 'store'])->name('advisers.store')->middleware(['auth', 'verified']);
Route::get('/advisers/{adviser}', [AdviserController::class, 'show'])->name('advisers.show')->middleware(['auth', 'verified']);
Route::get('/advisers/{adviser}/edit', [AdviserController::class, 'edit'])->name('advisers.edit')->middleware(['auth', 'verified']);
Route::put('/advisers/{adviser}', [AdviserController::class, 'update'])->name('advisers.update')->middleware(['auth', 'verified']);
Route::delete('/advisers/{adviser}', [AdviserController::class, 'destroy'])->name('advisers.destroy')->middleware(['auth', 'verified']);


Route::get('/client/{id}', [ClientController::class,'show'])->name('client.show')->middleware(['auth','verified']);


Route::get('/getInvoice/{id}', 'App\Http\Controllers\getInvoice@show');

Route::get('/getExpense/{id}','App\Http\Controllers\putExpense@show')->name('getExpense'); 

Route::get('/clients/{id}/download',[ClientController::class,'download'])->middleware(['auth','type','verified'])->name('clients.download');


Route::post('/adviser/send-reminder', [AdviserController::class, 'sendReminder'])->name('send-reminder');

Route::put('/putActivateUser/{id}',[ClientController::class,'update'])->name('putActivateUser');

Route::get('/client/{id}/invoices',[ClientController::class,'showInvoices'])->name('client.invoices');
Route::get('/client/{id}/expenses',[ClientController::class,'showExpenses'])->name('client.expenses');


Route::get('/clients/list', [ClientController::class, 'index'])->name('adviser.index')->middleware(['auth', 'verified','type']);
Route::get('/clients/{clients}', [ClientController::class, 'show'])->name('clients.show')->middleware(['auth', 'verified','type']);
require __DIR__.'/auth.php';
