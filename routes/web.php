<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SchoolMajorController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\CashTransactionController;
use App\Http\Controllers\CashTransactionFilterController;
use App\Http\Controllers\CashTransactionHistoryController;
use App\Http\Controllers\CashTransactionReportController;
use App\Http\Controllers\SchoolClassHistoryController;
use App\Http\Controllers\SchoolMajorHistoryController;
use App\Http\Controllers\StudentHistoryController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\HeadmasterController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Telegram\Bot\Api;
use App\Http\Controllers\RiwayatPembayaranController;
use App\Models\CashTransaction;

require __DIR__ . '/auth.php';

// If accessing root path "/" it will be redirect to /login
Route::redirect('/', 'login');

Route::middleware(['auth', 'redirectNonAdmin'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('students', StudentController::class)->except(
        'create',
        // 'show',
        // 'edit'
    );
    Route::get('detail-siswa/{id}', [StudentController::class, 'show']);
    Route::get('edit-siswa/{id}', [StudentController::class, 'edit']);
    Route::patch('students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::get('school-classes/{school_class}', 'SchoolClassController@show')->name('school-classes.show');
    Route::resource('school-classes', SchoolClassController::class)->except(
        'create',
        // 'edit',
        // 'show' // Excluding the 'show' route from the resource routes.
    );
    Route::get('detail-kelas/{id}', [SchoolClassController::class, 'show']);
    Route::get('edit-kelas/{id}', [SchoolClassController::class, 'edit']);
    Route::patch('school-classes/{id}', [SchoolClassController::class, 'update'])->name('school-classes.update');

    Route::resource('school-majors', SchoolMajorController::class)->except(
        'create',
        'show',
        'edit'
    );
    Route::resource('administrators', AdministratorController::class)->except(
        'create',
        'show',
        'edit',
        'destroy'
    );
    Route::resource('billings', BillingController::class)->except(
        'create',
        'show',
        'edit',
        'destroy'
    );
    Route::resource('transactions', TransactionController::class)->except(
        'create',
        'show',
        'edit',
        'destroy'
    );

    Route::post('/billings/{billing}/send-notification', [
        BillingController::class,
        'sendNotification',
    ])->name('billings.sendNotification');
    Route::post('/billings/send-notification-to-all', [
        BillingController::class,
        'sendNotificationToAll',
    ])->name('billings.sendNotificationToAll');

    Route::get(
        '/cash-transactions/filter',
        CashTransactionFilterController::class
    )->name('cash-transactions.filter');
    Route::resource(
        'cash-transactions',
        CashTransactionController::class
    )->except('create', 'show', 'edit');

    Route::get('detail-pembayaran/{id}', [CashTransactionController::class, 'show']);
    Route::get('edit-pembayaran/{id}', [CashTransactionController::class, 'edit']);
    Route::patch('cash-transactions/{id}', [CashTransactionController::class, 'update'])->name('cash-transactions.update');

    Route::get('/report', CashTransactionReportController::class)->name(
        'cash_transactions.index'
    );
    //  Report routes
    Route::get('/report', CashTransactionReportController::class)->name(
        'cash_transactions.index'
    );
    // End of report routes

    // Soft Deletes Routes
    Route::controller(StudentHistoryController::class)
        ->prefix('/students/history')
        ->name('students.')
        ->group(function () {
            Route::get('', 'index')->name('index.history');
            Route::post('{id}', 'restore')->name('restore.history');
            Route::delete('{id}', 'destroy')->name('destroy.history');
        });
    // Rute untuk Billing
    Route::prefix('billings')->group(function () {
        Route::get('/billings', BillingController::class);
        Route::get('/', [BillingController::class, 'index'])->name(
            'billings.index'
        );
        Route::post('/', [BillingController::class, 'store'])->name(
            'billings.store'
        );
        Route::put('/{billing}', [BillingController::class, 'update'])->name(
            'billings.update'
        );
        Route::delete('/{billing}', [
            BillingController::class,
            'destroy',
        ])->name('billings.destroy');
    });

    Route::controller(CashTransactionHistoryController::class)
        ->prefix('/cash-transactions/history')
        ->name('cash-transactions.')
        ->group(function () {
            Route::get('', 'index')->name('index.history');
            Route::post('{id}', 'restore')->name('restore.history');
            Route::delete('{id}', 'destroy')->name('destroy.history');
        });

    Route::controller(SchoolClassHistoryController::class)
        ->prefix('/school-classes/history')
        ->name('school-classes.')
        ->group(function () {
            Route::get('', 'index')->name('index.history');
            Route::post('{id}', 'restore')->name('restore.history');
            Route::delete('{id}', 'destroy')->name('destroy.history');
        });

    Route::controller(SchoolMajorHistoryController::class)
        ->prefix('/school-majors/history')
        ->name('school-majors.')
        ->group(function () {
            Route::get('', 'index')->name('index.history');
            Route::post('{id}', 'restore')->name('restore.history');
            Route::delete('{id}', 'destroy')->name('destroy.history');
        });

    Route::get('/transactions', [TransactionController::class, 'index'])->name(
        'transactions.index'
    );
    Route::get('/transactions/create', [
        TransactionController::class,
        'create',
    ])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name(
        'transactions.store'
    );
    Route::get('/transactions/{id}', [
        TransactionController::class,
        'show',
    ])->name('transactions.show');
    Route::get('/transactions/{id}/edit', [
        TransactionController::class,
        'edit',
    ])->name('transactions.edit');
    Route::put('/transactions/{id}', [
        TransactionController::class,
        'update',
    ])->name('transactions.update');
    Route::delete('/transactions/{id}', [
        TransactionController::class,
        'destroy',
    ])->name('transactions.destroy');
    Route::get('detail-pengeluaran/{id}', [TransactionController::class, 'show']);
    Route::get('edit-pengeluaran/{id}', [TransactionController::class, 'edit']);
    Route::patch('transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');

    // Route::post('/filter', [TransactionController::class, 'filter'])->name('transactions.filter');
    Route::post('transactions/filter', [TransactionController::class, 'filter'] )->name('transactions.filter');
    Route::post('cashTransactions/filter', [CashTransactionController::class, 'filter'] )->name('cashTransactions.filter');


    // Rute untuk fungsi-fungsi lain yang ada di HeadmasterController
    Route::resource('headmasters', HeadmasterController::class)->except(
        'create',
        'show',
        'edit',
        'destroy'
    );
    Route::post('/', [HeadmasterController::class, 'store'])->name(
        'headmasters.store'
    );

    Route::get('/user-management', [
        UserManagementController::class,
        'index',
    ])->name('user-management.index');

    // End Soft Deletes Routes

    require __DIR__ . '/export.php';
});
Route::get('/riwayat-pembayaran', [
    RiwayatPembayaranController::class,
    'showHistory',
])->name('siswa.riwayat_pembayaran')->middleware('auth');
Route::get('/tagihan', [
    RiwayatPembayaranController::class,
    'showTagihan',
])->name('siswa.tagihan')->middleware('auth');


// Route::get('/payment/{billing}', [
//     RiwayatPembayaranController::class,
//     'showPayment'])->name('siswa.payment');

// Route::middleware(['auth', 'role:siswa'])->group(function () {
//     Route::get('/riwayat-pembayaran', [
//         RiwayatPembayaranController::class,
//         'showHistory',
//     ])->name('siswa.riwayat_pembayaran');

//     Route::get('/tagihan', [
//         RiwayatPembayaranController::class,
//         'showTagihan',
//     ])->name('siswa.tagihan');
// });

// Route::middleware('auth', 'kepala.sekolah')->group(function () {
//     // Tambahkan route-route yang ingin dibatasi aksesnya untuk "Kepala Sekolah" di sini
//     Route::get('/dashboard-kepala-sekolah', [HeadmasterController::class, 'dashboard'])->name('dashboard_kepala_sekolah');
//     Route::get('/data-pembayaran', [HeadmasterController::class, 'dataPembayaran'])->name('data_pembayaran');
//     Route::get('/data-tagihan', [HeadmasterController::class, 'dataTagihan'])->name('data_tagihan');
// });

// Route::middleware(['auth', 'role:kepsek'])->group(function () {
//     // Tambahkan route-route yang ingin dibatasi aksesnya untuk "Kepala Sekolah" di sini
//     Route::get('/dashboard', DashboardController::class)->name('dashboard');
//     // Route::get('/data-pembayaran', [HeadmasterController::class, 'dataPembayaran'])->name('data_pembayaran');
//     // Route::get('/data-tagihan', [HeadmasterController::class, 'dataTagihan'])->name('data_tagihan');
// });
