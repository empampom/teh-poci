<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\BedaHargaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembayaranController;

Route::middleware('auth')->group(function () {
    Route::get('/', [TransaksiController::class, 'home'])->name('transaksi.home');
    Route::view('/admin', 'admin')->name('admin.index');
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna/store', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::post('/pengguna/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::post('/pengguna/update', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::get('/pengguna/destroy', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
    Route::get('/cabang', [CabangController::class, 'index'])->name('cabang.index');
    Route::post('/cabang/store', [CabangController::class, 'store'])->name('cabang.store');
    Route::post('/cabang/edit', [CabangController::class, 'edit'])->name('cabang.edit');
    Route::post('/cabang/update', [CabangController::class, 'update'])->name('cabang.update');
    Route::get('/cabang/destroy', [CabangController::class, 'destroy'])->name('cabang.destroy');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::post('/pembayaran/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
    Route::post('/pembayaran/update', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::get('/pembayaran/destroy', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::post('/menu/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::post('/menu/update', [MenuController::class, 'update'])->name('menu.update');
    Route::get('/menu/destroy', [MenuController::class, 'destroy'])->name('menu.destroy');
    Route::get('/beda_harga', [BedaHargaController::class, 'index'])->name('beda_harga.index');
    Route::post('/beda_harga/store', [BedaHargaController::class, 'store'])->name('beda_harga.store');
    Route::post('/beda_harga/edit', [BedaHargaController::class, 'edit'])->name('beda_harga.edit');
    Route::post('/beda_harga/update', [BedaHargaController::class, 'update'])->name('beda_harga.update');
    Route::get('/beda_harga/destroy', [BedaHargaController::class, 'destroy'])->name('beda_harga.destroy');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [LaporanController::class, 'result'])->name('laporan.result');
});

Route::get('login', [AuthController::class, 'LoginForm'])->name('login');
Route::post('login', [AuthController::class, 'LoginAction'])->name('login.action');
Route::get('/{cabang_id}', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/{cabang_id}/store', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/{cabang_id}/print/{id}', [TransaksiController::class, 'print'])->name('transaksi.print');
