<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\FaqController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\admin\UserController;
use \App\Http\Controllers\admin\InspectionCenterController;
use \App\Http\Controllers\admin\InspectionTypeController;
use \App\Http\Controllers\admin\TransactionController;
use \App\Http\Controllers\admin\TraderMark;
use \App\Http\Controllers\admin\CarCondtionQuestionController;

Route::get('/admin', [AdminController::class, 'index'])->name('login');
Route::group(['prefix' => 'admin'], function () {
    Route::post('admin_login', [AdminController::class, 'admin_login']);
    // Start Register Page
    Route::match(['post', 'get'], 'register', [AdminController::class, 'register']);
    Route::group(['middleware' => ['auth']], function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('dashboard', 'dashboard');
            Route::post('logout', 'logout')->name('logout');
            // Start Update Admin Details
            Route::match(['post', 'get'], 'update_admin_password', 'update_admin_password');
            Route::match(['post', 'get'], 'update_admin_details', 'update_admin_details');
            // Start Update Admin Password
            // update admin password
            Route::match(['post', 'get'], 'update_admin_password', 'update_admin_password');
            // check Admin Password
            Route::post('check_admin_password', 'check_admin_password');
        });
        Route::controller(UserController::class)->group(function () {
            Route::get('users', 'index');
        });
        //////////////////////////// Start Faqs /////////////////
        ///
        Route::controller(FaqController::class)->group(function () {
            Route::get('faqs', 'index');
            Route::match(['post', 'get'], 'faq/store', 'store');
            Route::match(['post', 'get'], 'faq/update/{id}', 'update');
            Route::post('faq/delete/{id}', 'delete');
        });
        ////////////////////////// start Inspection Center ////////////
        ///

        Route::controller(InspectionCenterController::class)->group(function () {

            Route::get('inspection-center', 'index');
            Route::match(['post', 'get'], 'inspection-center/store', 'store');
            Route::match(['post', 'get'], 'inspection-center/update/{id}', 'update');
            Route::post('inspection-center/delete/{id}', 'delete');
        });

        //////////////////// Start Inspection Type
        ///
        Route::controller(InspectionTypeController::class)->group(function () {
            Route::get('inspection-type/{centerid}', 'index');
            Route::match(['post', 'get'], 'inspection-type/store', 'store');
            Route::match(['post', 'get'], 'inspection-type/update/{id}', 'update');
            Route::post('inspection-type/delete/{id}', 'delete');
        });
        //////////////// Start Transactions
        ///
        Route::controller(TransactionController::class)->group(function () {
            Route::get('transactions', 'index');
            Route::get('transaction/show/{id}', 'show');
            Route::match(['post', 'get'], 'transaction/update/{id}', 'update');
            Route::get('transaction/steps', 'steps');
        });

        //////////////// Start TradeMarks ///////////////////
        ///
        Route::controller(\App\Http\Controllers\admin\TradeMarkController::class)->group(function () {
            Route::get('trademarks', 'index');
            Route::match(['post','get'],'trademark/store', 'store');
            Route::match(['post','get'],'trademark/update/{id}', 'update');
            Route::post('trademark/delete/{id}', 'delete');
        });
        ////////////////////  Start Terms ////////////
        ///
        Route::controller(\App\Http\Controllers\admin\TermController::class)->group(function (){
           Route::match(['post','get'],'terms','index');
        });
        ////////////// Start Car Condition Question /////////////
        ///
        Route::controller(CarCondtionQuestionController::class)->group(function (){
          Route::get('questions','index');
          Route::match(['post','get'],'question/store','store');
          Route::match(['post','get'],'question/update/{id}','update');
          Route::post('question/delete/{id}','delete');
        });
    });
});
