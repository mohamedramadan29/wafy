<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\front\UserController;
use \App\Http\Controllers\front\OrdersController;
Route::get('/', function () {
    return view('front.index');
});


Route::controller(UserController::class)->group(function (){
    Route::match(['post','get'],'register','register');
    Route::post('login','login');
    Route::group(['middleware' => 'auth'], function () {

        Route::get('user/dashboard','dashboard');
    });

});
Route::controller(OrdersController::class)->group(function (){
    Route::group(['middleware' => 'auth'], function () {
        Route::match(['post', 'get'], 'user/start_order', 'start_order');
    });
});
include 'admin.php';
