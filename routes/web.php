<?php

use App\Http\Controllers\KtpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/ktp', [KtpController::class, 'index'])->name('ktp.index');
Route::get('/ktp/create', [KtpController::class, 'create'])->name('ktp.create');
Route::post('/ktp', [KtpController::class, 'store'])->name('ktp.store');
Route::get('/ktp/{ktp}', [KtpController::class, 'show'])->name('ktp.show');
Route::get('/ktp/{ktp}/edit', [KtpController::class, 'edit'])->name('ktp.edit');
Route::put('/ktp/{ktp}', [KtpController::class, 'update'])->name('ktp.update');
Route::delete('/ktp/{ktp}', [KtpController::class, 'destroy'])->name('ktp.destroy');

Route::get('/ktp/cities/{provinceCode}', [KTPController::class, 'getCities']);
Route::get('/ktp/districts/{cityCode}', [KTPController::class, 'getDistricts']);
Route::get('/ktp/villages/{districtCode}', [KTPController::class, 'getVillages']);