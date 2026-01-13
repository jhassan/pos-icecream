<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/admin.php';
require __DIR__.'/client.php';

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Admin\InvoiceReportController;
use App\Http\Controllers\Client\InvoiceController;

Route::middleware('auth:client')->prefix('client')->group(function () {

    // Route::get('/invoice/create', [InvoiceController::class, 'createInvoice'])
    //     ->name('client.invoice.create');

    // Route::post('/invoice/store', [InvoiceController::class, 'store'])
    //     ->name('client.invoice.store');

    // Route::get('/invoice/print/{id}', [InvoiceController::class, 'print'])
    //     ->name('client.invoice.print');

    // // Route to print invoice
    // Route::get('/invoice/print/{id}', function ($id) {
    //     $invoice = Invoice::with('items.product')->findOrFail($id);

    //     return view('client.invoice.print', compact('invoice'));
    // })->name('client.invoice.print');

});

Route::prefix('admin')->group(function () {

    Route::get('reports/invoice', [InvoiceReportController::class, 'index'])
        ->name('admin.invoice.report');

    Route::get('reports/invoice-data', [InvoiceReportController::class, 'getData'])
        ->name('admin.invoice.report.data');

});
