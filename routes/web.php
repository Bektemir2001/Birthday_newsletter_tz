<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\MailingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.index');
});

Route::get('/failed-jobs', function (){
    dd(\Illuminate\Support\Facades\DB::table('failed_jobs')->get());
});
Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');

    Route::group(['prefix' => 'customers'], function (){
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
        Route::post('/file', [CustomerController::class, 'uploadCustomerFile'])->name('customers.upload.file');
    });

    Route::group(['prefix' => 'mailing'], function (){
        Route::post('/', [MailingController::class, 'store'])->name('mailing.store');
        Route::get('/', [MailingController::class, 'index'])->name('mailing.index');
        Route::get('/stop/{mailing}', [MailingController::class, 'stop'])->name('mailing.stop');
        Route::get('/show/{mailing}', [MailingController::class, 'show'])->name('mailing.show');
        Route::get('/chart', [MailingController::class, 'chart'])->name('mailing.chart');
        Route::get('/pie', [MailingController::class, 'pie'])->name('mailing.pie');
    });
});
