<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembayaranController;

Route::middleware('auth')->group(function () {
    Route::view('/admin', 'admin')->name('admin.index');
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna/store', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/cabang', [CabangController::class, 'index'])->name('cabang.index');
    Route::post('/cabang/store', [CabangController::class, 'store'])->name('cabang.store');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [LaporanController::class, 'result'])->name('laporan.result');
});


Route::get('login', [AuthController::class, 'LoginForm'])->name('login');
Route::post('login', [AuthController::class, 'LoginAction'])->name('login.action');
Route::get('/', [TransaksiController::class, 'home'])->name('transaksi.home');
Route::get('/{cabang_id}', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/{cabang_id}/store', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/{cabang_id}/print/{id}', [TransaksiController::class, 'print'])->name('transaksi.print');
