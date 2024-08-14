<?php

use App\Http\Controllers\KtpController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\mataKuliahController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\RuangKelasController;
use App\Http\Controllers\TahunAjaranController;
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

//crud mahasiswa
Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
Route::get('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
Route::put('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

// ajax
Route::get('/mahasiswa/cities/{provinceCode}', [MahasiswaController::class, 'getCities']);
Route::get('/mahasiswa/districts/{cityCode}', [MahasiswaController::class, 'getDistricts']);
Route::get('/mahasiswa/villages/{districtCode}', [MahasiswaController::class, 'getVillages']);

// ruang kelas
Route::get('/ruang-kelas', [RuangKelasController::class, 'index'])->name('kelas.index');
Route::get('/ruang-kelas/create', [RuangKelasController::class, 'create'])->name('kelas.create');
Route::post('/ruang-kelas', [RuangKelasController::class, 'store'])->name('kelas.store');
Route::get('/ruang-kelas/{kelas}/edit', [RuangKelasController::class, 'edit'])->name('kelas.edit');
Route::put('/ruang-kelas/{kelas}', [RuangKelasController::class, 'update'])->name('kelas.update');
Route::delete('/ruang-kelas/{kelas}', [RuangKelasController::class, 'destroy'])->name('kelas.destroy');
// Route::get('/ruang-kelas/show/{id}', [RuangKelasController::class, 'show'])->name('kelas.show');

// tahun ajaran
Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun-ajaran.index');
Route::get('/tahun-ajaran/create', [TahunAjaranController::class, 'create'])->name('tahun-ajaran.create');
Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store');
Route::get('/tahun-ajaran/{tahunAjaran}/edit', [TahunAjaranController::class, 'edit'])->name('tahun-ajaran.edit');
Route::put('/tahun-ajaran/{tahunAjaran}', [TahunAjaranController::class, 'update'])->name('tahun-ajaran.update');
Route::delete('/tahun-ajaran/{tahunAjaran}', [TahunAjaranController::class, 'destroy'])->name('tahun-ajaran.destroy');

// semester
Route::get('/semester', [SemesterController::class, 'index'])->name('semester.index');
Route::get('/semester/create', [SemesterController::class, 'create'])->name('semester.create');
Route::post('/semester', [SemesterController::class, 'store'])->name('semester.store');
Route::get('/semester/{semester}/edit', [SemesterController::class, 'edit'])->name('semester.edit');
Route::put('/semester/{semester}', [SemesterController::class, 'update'])->name('semester.update');
Route::delete('/semester/{semester}', [SemesterController::class, 'destroy'])->name('semester.destroy');
// Route::get('/semester/show/{id}', [SemesterController::class, 'show'])->name('semester.show');

//CRUD Mata Kuliah
Route::get('/mataKuliah', [mataKuliahController::class, "index"])->name('mataKuliah.index');
Route::delete('/mataKuliah/delete/{id}', [mataKuliahController::class, 'destroy'])->name('mataKuliah.destroy');
Route::post('/mataKuliah/store', [mataKuliahController::class, 'store'])->name('mataKuliah.store');
Route::get('/mataKuliah/create', [mataKuliahController::class, 'create'])->name('mataKuliah.create');
Route::get('/mataKuliah/edit/{id}', [mataKuliahController::class, 'edit'])->name('mataKuliah.edit');
Route::put('/mataKuliah/update/{id}', [mataKuliahController::class, 'update'])->name('mataKuliah.update');
Route::get('/mataKuliah/show/{id}', [mataKuliahController::class, 'show'])->name('mataKuliah.show');
