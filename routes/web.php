<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RuangKelasController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\PaketMataKuliahController;

Route::get('/', function () {
    return view('home');
});

Route::get('/wizard', function () {
    return view('wizard');
});


// jurusan
Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
Route::get('/jurusan/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
Route::put('/jurusan/{jurusan}', [JurusanController::class, 'update'])->name('jurusan.update');
Route::delete('/jurusan/{jurusan}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');
// Route::get('/jurusan/show/{id}', [JurusanController::class, 'show'])->name('jurusan.show');

// prodi
Route::get('/prodi', [ProgramStudiController::class, 'index'])->name('prodi.index');
Route::get('/prodi/create', [ProgramStudiController::class, 'create'])->name('prodi.create');
Route::post('/prodi', [ProgramStudiController::class, 'store'])->name('prodi.store');
Route::get('/prodi/{prodi}/edit', [ProgramStudiController::class, 'edit'])->name('prodi.edit');
Route::put('/prodi/{prodi}', [ProgramStudiController::class, 'update'])->name('prodi.update');
Route::delete('/prodi/{prodi}', [ProgramStudiController::class, 'destroy'])->name('prodi.destroy');
Route::get('/prodi/show/{id}', [ProgramStudiController::class, 'show'])->name('prodi.show');


// CRUD Mahasiswa
Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'storeOrUpdate'])->name('mahasiswa.store');
Route::get('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
Route::put('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'storeOrUpdate'])->name('mahasiswa.update');
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

// Mata Kuliah
Route::get('/mata-kuliah', [MataKuliahController::class, 'index'])->name('mata-kuliah.index');
Route::get('/mata-kuliah/create', [MataKuliahController::class, 'create'])->name('mata-kuliah.create');
Route::post('/mata-kuliah', [MataKuliahController::class, 'store'])->name('mata-kuliah.store');
Route::get('/mata-kuliah/{matkul}/edit', [MataKuliahController::class, 'edit'])->name('mata-kuliah.edit');
Route::put('/mata-kuliah/{matkul}', [MataKuliahController::class, 'update'])->name('mata-kuliah.update');
Route::delete('/mata-kuliah/{matkul}', [MataKuliahController::class, 'destroy'])->name('mata-kuliah.destroy');
Route::get('/mata-kuliah/show/{id}', [MataKuliahController::class, 'show'])->name('mata-kuliah.show');

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


Route::get('/paket-matakuliah', [PaketMataKuliahController::class, 'index'])->name('paket-matakuliah.index');
Route::get('/paket-matakuliah/create', [PaketMataKuliahController::class, 'create'])->name('paket-matakuliah.create');
Route::post('/paket-matakuliah/store', [PaketMataKuliahController::class, 'store'])->name('paket-matakuliah.store');
Route::get('/paket-matakuliah/show/{id}', [PaketMataKuliahController::class, 'show'])->name('paket-matakuliah.show');
Route::get('/paket-matakuliah/edit/{id}', [PaketMataKuliahController::class, 'edit'])->name('paket-matakuliah.edit');
Route::put('/paket-matakuliah/{id}', [PaketMataKuliahController::class, 'update'])->name('paket-matakuliah.update');
Route::delete('/paket-matakuliah/{id}', [PaketMataKuliahController::class, 'destroy'])->name('paket-matakuliah.destroy');

// Route untuk mengambil mata kuliah berdasarkan program studi dan semester
Route::get('/paket-matakuliah/get-matakuliah', [PaketMataKuliahController::class, 'getMataKuliah'])->name('get-matakuliah');
