<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/karyawan', [KaryawanController::class, 'index'])->name('admin.karyawan');
Route::post('/admin/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
Route::put('/admin/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
Route::delete('/admin/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');