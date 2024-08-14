<?php

use App\Http\Controllers\KtpController;
use App\Http\Controllers\mataKuliahController;
use Illuminate\Support\Facades\Route;
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

//matkul
// Route::get('master/mataKuliah/create', function () {
//     return view('master/mataKuliah/create');
// });

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

//CRUD Mata Kuliah
Route::get('/mataKuliah', [mataKuliahController::class, "index"])->name('mataKuliah.index');
Route::delete('/mataKuliah/delete/{id}', [mataKuliahController::class, 'destroy'])->name('mataKuliah.destroy');
Route::post('/mataKuliah/store', [mataKuliahController::class, 'store'])->name('mataKuliah.store');
Route::get('/mataKuliah/create', [mataKuliahController::class, 'create'])->name('mataKuliah.create');
Route::get('/mataKuliah/edit/{id}', [mataKuliahController::class, 'edit'])->name('mataKuliah.edit');
Route::put('/mataKuliah/update/{id}', [mataKuliahController::class, 'update'])->name('mataKuliah.update');
Route::get('/mataKuliah/show/{id}', [mataKuliahController::class, 'show'])->name('mataKuliah.show');