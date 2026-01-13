<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InvoiceReportController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // admin pages
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    // web.php
    // Route::get('admin/reports/invoice', [InvoiceReportController::class, 'index'])
    //     ->name('admin.invoice.report');

    // Route::get('admin/reports/invoice-data', [InvoiceReportController::class, 'getData'])
    //     ->name('admin.invoice.report.data');
});
