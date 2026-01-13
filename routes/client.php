<?php

use App\Http\Controllers\Client\Auth\LoginController;
use App\Http\Controllers\Client\InvoiceController;
use App\Http\Controllers\Client\InvoiceReportController;
use App\Http\Controllers\Client\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('client')->name('client.')->group(function () {

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');

    Route::get('/products-by-category', [ProductController::class, 'byCategory'])
        ->name('products.by.category');

    Route::get('/invoice/create', [InvoiceController::class, 'createInvoice'])
        ->name('invoice.create');

    Route::post('/invoice/store', [InvoiceController::class, 'store'])
        ->name('invoice.store');

    Route::get('/invoice/print/{id}', [InvoiceController::class, 'print'])
        ->name('invoice.print');

    // Route to print invoice
    // Route::get('/invoice/print/{id}', function ($id) {
    //     $invoice = Invoice::with('items.product')->findOrFail($id);

    //     return view('client.invoice.print', compact('invoice'));
    // })->name('client.invoice.print');

    Route::middleware('auth:client')->group(function () {
        Route::get('dashboard', function () {
            return view('client.dashboard');
        })->name('dashboard');

        // Show all products
        Route::get('/products', [ProductController::class, 'index'])->name('client.products');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/invoice-report', [InvoiceReportController::class, 'index'])
            ->name('invoice.report');

        Route::get('/invoice/{id}', [InvoiceReportController::class, 'show'])
            ->name('invoice.show');

        Route::post('/invoice/{invoice}/return', [InvoiceReportController::class, 'returnProducts'])
            ->name('invoice.return');

    });

});
