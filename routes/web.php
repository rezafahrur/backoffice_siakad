<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RuangKelasController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\PaketMataKuliahController;



Route::get('/wizard', function () {
    return view('wizard');
});

Route::get('/test', function () {
    return view('layouts.custom-test');
});


Route::group(['middleware' => ['auth:hr']], function ()
{
    // get '/' to redirect to '/home'
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

    // route profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

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

    // Bayar
    Route::post('/mahasiswa/bayar', [MahasiswaController::class, 'bayar'])->name('mahasiswa.bayar');
    Route::get('/get-paket-matakuliah-details/{id}', [MahasiswaController::class, 'getPaketMatakuliahDetails']);
    Route::get('/get-paket-matakuliah-by-semester', [MahasiswaController::class, 'getPaketMataKuliahBySemester']);

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
    Route::get('/position', [PositionController::class, 'index'])->name('position.index');
    Route::post('/position', [PositionController::class, 'store'])->name('position.store');
    Route::get('/position/{id}/edit', [PositionController::class, 'edit'])->name('position.edit');
    Route::put('/position/{id}', [PositionController::class, 'update'])->name('position.update');
    Route::delete('/position/{id}', [PositionController::class, 'destroy'])->name('position.destroy');
    Route::get('/position/show/{id}', [PositionController::class, 'show'])->name('position.show');
    Route::get('/position/create', [PositionController::class, 'create'])->name('position.create');

    //crud hr
    Route::get('/hr', [HrController::class, 'index'])->name('hr.index');
    Route::post('/hr', [HrController::class, 'store'])->name('hr.store');
    Route::get('/hr/{id}/edit', [HrController::class, 'edit'])->name('hr.edit');
    Route::put('/hr/{id}', [HrController::class, 'update'])->name('hr.update');
    Route::delete('hr/{id}', [HrController::class, 'destroy'])->name('hr.destroy');
    Route::get('/hr/show/{id}', [HrController::class, 'show'])->name('hr.show');
    Route::get('/hr/create', [HrController::class, 'create'])->name('hr.create');


    Route::get('/paket-matakuliah', [PaketMataKuliahController::class, 'index'])->name('paket-matakuliah.index');
    Route::get('/paket-matakuliah/create', [PaketMataKuliahController::class, 'create'])->name('paket-matakuliah.create');
    Route::post('/paket-matakuliah', [PaketMataKuliahController::class, 'store'])->name('paket-matakuliah.store');
    Route::get('/paket-matakuliah/show/{id}', [PaketMataKuliahController::class, 'show'])->name('paket-matakuliah.show');
    Route::get('/paket-matakuliah/{id}/edit', [PaketMataKuliahController::class, 'edit'])->name('paket-matakuliah.edit');
    Route::put('/paket-matakuliah/{id}', [PaketMataKuliahController::class, 'update'])->name('paket-matakuliah.update');
    Route::delete('/paket-matakuliah/{id}', [PaketMataKuliahController::class, 'destroy'])->name('paket-matakuliah.destroy');

    // Route untuk mengambil mata kuliah berdasarkan program studi dan semester
    Route::get('/paket-matakuliah/get-matakuliah/{programStudiId}/{semester}', [PaketMataKuliahController::class, 'getMataKuliah'])->name('get-matakuliah');

    //crud berita
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/show/{id}', [BeritaController::class, 'show'])->name('berita.show');
    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    // paket jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    Route::get('/jadwal/show/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
    Route::get('/jadwal/details/{paketMataKuliah}', [JadwalController::class, 'getPaketDetails']);

    Route::get('/nilai/create', [NilaiController::class, 'index'])->name('nilai');

});

//login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/loginFrom', [LoginController::class, 'generateLoginURL'])->name('login.generateURL');
Route::get('/prosesLogin/{hp}/{otp}', [LoginController::class, 'prosesLogin'])->name('login.processLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
