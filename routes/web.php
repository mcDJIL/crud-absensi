<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\IsLoginMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(Authenticated::class)->group(function() {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([ IsLoginMiddleware::class, 'role:admin' ])->group(function() {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/karyawan', [KaryawanController::class, 'index'])->name('admin.karyawan');
    Route::post('/admin/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::put('/admin/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/admin/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    Route::get('/import', [ImportController::class, 'showImportPage'])->name('import');
    Route::post('/import', [ImportController::class, 'import'])->name('karyawan.import');

    Route::get('/export', [ExportController::class, 'downloadPdf'])->name('karyawan.export');

    Route::get('/admin/absensi', [AbsensiController::class, 'index'])->name('admin.absensi');
    Route::post('/admin/absensi/masuk/{id}', [AbsensiController::class, 'clockIn'])->name('clock-in');
    Route::post('/admin/absensi/keluar/{id}', [AbsensiController::class, 'clockOut'])->name('clock-out');
    Route::post('/admin/absensi/not-present/{id}', [AbsensiController::class, 'notPresent'])->name('not-present');
    Route::get('/absensi/export', [ExportController::class, 'exportAbsen'])->name('absensi.export');
});

Route::middleware([ 'role:user' ])->group(function() {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/absensi', [UserController::class, 'showAbsensiPage'])->name('user.absensi');
    Route::get('/absensi/rekap', [ExportController::class, 'rekapAbsen'])->name('absensi.rekap');
});
