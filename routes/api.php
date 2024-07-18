<?php

use App\Http\Controllers\Api\AbsensiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AbsensiController::class)->group(function() {
    Route::get('v1/total-absent', 'getTotalAbsent');
    Route::get('v1/absent-onward', 'getAbsentOnward');
    Route::get('v1/best-employee', 'bestEmployee');
});