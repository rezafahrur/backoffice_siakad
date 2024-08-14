<?php

use App\Http\Controllers\KtpController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\RuangKelasController;

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

// ruang kelas
Route::get('/ruang-kelas', [RuangKelasController::class, 'index'])->name('kelas.index');
Route::get('/ruang-kelas/create', [RuangKelasController::class, 'create'])->name('kelas.create');
Route::post('/ruang-kelas', [RuangKelasController::class, 'store'])->name('kelas.store');
Route::get('/ruang-kelas/{kelas}/edit', [RuangKelasController::class, 'edit'])->name('kelas.edit');
Route::put('/ruang-kelas/{kelas}', [RuangKelasController::class, 'update'])->name('kelas.update');
Route::delete('/ruang-kelas/{kelas}', [RuangKelasController::class, 'destroy'])->name('kelas.destroy');
// Route::get('/ruang-kelas/show/{id}', [RuangKelasController::class, 'show'])->name('kelas.show');
