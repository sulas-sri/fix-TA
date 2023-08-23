<?php

use App\Http\Controllers\BillingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Export\AdministratorController;
use App\Http\Controllers\Export\StudentController;
use App\Http\Controllers\Export\CashTransactionController;
use App\Http\Controllers\Export\TransactionController;
use App\Http\Controllers\Export\CashTransactionReportController;
use App\Http\Controllers\Export\CetakKwitansiPDFController;

Route::get('/report/filter/export/{start_date}/{end_date}', CashTransactionReportController::class)->name('report.export');
Route::get('/students/export', StudentController::class)->name('students.export');
Route::get('/cash-transactions/export', CashTransactionController::class)->name('cash-transactions.export');
Route::get('/administrators/export', AdministratorController::class)->name('administrators.export');
Route::get('/billings/export', BillingController::class)->name('billings.export');
Route::get('/cetak-kwitansi/{id}', [CetakKwitansiPDFController::class, 'cetakKwitansi'])->name('cetak-kwitansi');
Route::get('/transactions/export', TransactionController::class)->name('transactions.export');
