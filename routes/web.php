<?php


use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Routåe;

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

Route::get('/customer', function () {
    return view('customer');
});

Route::get('/user', function () {
    return view('user');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified')->name('home');



Route::group(['middleware' => ['auth','verified']], function() {
    Auth::routes();

    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('sales', \App\Http\Controllers\SaleController::class);
    Route::resource('configs', \App\Http\Controllers\ConfigController::class);
});

