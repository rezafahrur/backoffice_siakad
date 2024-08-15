<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrController;
use App\Http\Controllers\KtpController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProgramStudiController;

Route::get('/', function () {
    return view('home');
});

Route::get('master/prodi/index', function () {
    return view('master/prodi/index');
});

Route::get('/master/prodi/create', function () {
    return view('master/prodi/create');
});

Route::get('/master/prodi/edit/{id}', function () {
    return view('/master/prodi/edit/{id}');
});

//show
Route::get('/master/prodi/show/{id}', function () {
    return view('/master/prodi/show/{id}');
});

//crud program studi
Route::get('/master/prodi/index', [ProgramStudiController::class, 'index'])->name('prodi.index');
Route::post('/master/prodi/store', [ProgramStudiController::class, 'store'])->name('prodi.store');
Route::get('/master/prodi/edit/{id}', [ProgramStudiController::class, 'edit'])->name('prodi.edit');
Route::put('/master/prodi/update/{id}', [ProgramStudiController::class, 'update'])->name('prodi.update');
Route::delete('master/prodi/delete/{id}', [ProgramStudiController::class, 'destroy'])->name('prodi.destroy');
Route::get('/master/prodi/show/{id}', [ProgramStudiController::class, 'show'])->name('prodi.show');
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

//crud position
Route::get('/master/position/index', [PositionController::class, 'index'])->name('position.index');
Route::post('/master/position/store', [PositionController::class, 'store'])->name('position.store');
Route::get('/master/position/edit/{id}', [PositionController::class, 'edit'])->name('position.edit');
Route::put('/master/position/update/{id}', [PositionController::class, 'update'])->name('position.update');
Route::delete('master/position/delete/{id}', [PositionController::class, 'destroy'])->name('position.destroy');
Route::get('/master/position/show/{id}', [PositionController::class, 'show'])->name('position.show');
Route::get('/master/position/create', [PositionController::class, 'create'])->name('position.create');

//crud hr
Route::get('/master/hr/index', [HrController::class, 'index'])->name('hr.index');
Route::post('/master/hr/store', [HrController::class, 'store'])->name('hr.store');
Route::get('/master/hr/edit/{id}', [HrController::class, 'edit'])->name('hr.edit');
Route::put('/master/hr/update/{id}', [HrController::class, 'update'])->name('hr.update');
Route::delete('master/hr/delete/{id}', [HrController::class, 'destroy'])->name('hr.destroy');
Route::get('/master/hr/show/{id}', [HrController::class, 'show'])->name('hr.show');
Route::get('/master/hr/create', [HrController::class, 'create'])->name('hr.create');

