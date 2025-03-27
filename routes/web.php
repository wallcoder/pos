<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/admin/invoices/{order}', [InvoiceController::class, 'show']);
Route::get('/admin/invoices/{order}/download', [InvoiceController::class, 'download']);