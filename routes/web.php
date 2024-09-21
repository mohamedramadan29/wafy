<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\front\UserController;
use \App\Http\Controllers\front\OrdersController;
use \App\Http\Controllers\front\PaymentTransactionsController;
Route::get('/', function () {
    return view('front.index');
});


Route::controller(UserController::class)->group(function () {
    Route::match(['post', 'get'], 'register', 'register');
    Route::post('login', 'login');
 //   Route::match(['post','get'],'forget-password','forget_password');
    Route::get('forget-password', [UserController::class, 'forget_password'])->name('forget-password');
    Route::post('forget-password', [UserController::class, 'forget_password']);

    Route::post('forget-password-step2', [UserController::class, 'forget_password_step2'])->name('forget-password-step2');

    Route::post('reset-password', [UserController::class, 'reset_password'])->name('reset-password');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('user/dashboard', 'dashboard');
        Route::match(['post', 'get'], 'user/profile', 'account');
        Route::match(['post', 'get'], 'user/change-password', 'change_password');
        Route::get('user/logout', 'logout');
    });
    Route::get('terms','terms');

});
Route::controller(OrdersController::class)->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::match(['post', 'get'], 'user/add-transaction', 'start_order');
        Route::get('user/transactions', 'index');
        Route::match(['post', 'get'], 'user/transaction/edit/{seller_id}-{transaction_slug}', 'update');
        Route::match(['post', 'get'], 'user/transaction/buyer_start/{seller_id}-{transaction_slug}', 'buyer_start_transaction');
        Route::get('user/transaction/delete/{id}', 'delete');
        Route::get('/get-inspection-types/{centerId}', 'getInspectionTypes');
        Route::get('/get-inspection-price/{typeId}', 'getInspectionPrice');
        Route::post('transaction/selectcenter/{transaction_id}','select_center');
        Route::match(['post','get'],'transaction_invoice/{seller_id}-{transaction_slug}','transaction_invoice');
        Route::get('/get-types/{markId}','getTypes');
    });
    Route::get('transaction/{seller_id}-{slug}', 'show');
});

////////////// Payment Transaction Controller
///
Route::controller(PaymentTransactionsController::class)->group(function (){
    Route::post('pay_invoice/{id}','pay_invoice');
    Route::get('pay_invoice/callback/{id}','callback');
    Route::get('payment_success','payment_success')->name('payment.success');
    Route::get('payment_failed','payment_failed')->name('payment.failed');
});

include 'admin.php';
