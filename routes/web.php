<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\MailingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin'], function (){
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');

    Route::group(['prefix' => 'customers'], function (){
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
        Route::post('/file', [CustomerController::class, 'uploadCustomerFile'])->name('customers.upload.file');
    });

    Route::group(['prefix' => 'sms_mailing'], function (){
        Route::post('/', [MailingController::class, 'store'])->name('sms.store');
        Route::get('/', [MailingController::class, 'index'])->name('sms.index');
    });
});
