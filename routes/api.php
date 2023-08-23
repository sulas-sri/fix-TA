<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\API\v1\SchoolMajorController;
use App\Http\Controllers\API\v1\AdministratorController;
use App\Http\Controllers\API\v1\CashTransactionController;
use App\Http\Controllers\API\v1\DashboardChartController;
use App\Http\Controllers\API\v1\LoginController;
use App\Http\Controllers\API\v1\LogoutController;
use App\Http\Controllers\API\v1\StudentController;
use App\Http\Controllers\API\v1\BillingController;
use App\Http\Controllers\RiwayatPembayaranController;

Route::name('api.')->prefix('v1')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::middleware('jwt')->group(function () {
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

        Route::get('/school-class/{id}', [SchoolClassController::class, 'show'])->name('school-class.show');
        Route::get('/school-class/{id}/edit', [SchoolClassController::class, 'edit'])->name('school-class.edit');

        Route::get('/student/{id}', [StudentController::class, 'show'])->name('student.show');
        Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');

        Route::get('/school-major/{id}', [SchoolMajorController::class, 'show'])->name('school-major.show');
        Route::get('/school-major/{id}/edit', [SchoolMajorController::class, 'edit'])->name('school-major.edit');

        Route::get('/administrator/{id}', [AdministratorController::class, 'show'])->name('administrator.show');
        Route::get('/administrator/{id}/edit', [AdministratorController::class, 'edit'])->name('administrator.edit');

        Route::get('/cash-transaction/{id}', [CashTransactionController::class, 'show'])->name('cash-transaction.show');
        Route::get('/cash-transaction/{id}/edit', [CashTransactionController::class, 'edit'])->name('cash-transaction.edit');

        Route::get('/billing/{id}', [BillingController::class, 'show'])->name('billings.show');
        Route::get('/billing/{id}/edit', [BillingController::class, 'edit'])->name('billings.edit');
        // Route::post('billings/{billing}/send-notification', [BillingController::class, 'sendNotification'])->name('billings.sendNotification');

        Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('transaction.show');
        Route::get('/transaction/{id}/edit', [TransactionController::class, 'edit'])->name('transaction.edit');

        Route::get('/headmaster/{id}', [HeadmasterController::class, 'show'])->name('headmaster.show');
        Route::get('/headmaster/{id}/edit', [HeadmasterController::class, 'edit'])->name('headmaster.edit');

        Route::get('/chart', DashboardChartController::class)->name('chart');

        Route::post('/midtrans-callback', [
            RiwayatPembayaranController::class,
            'callback',
        ]);
    });
});
