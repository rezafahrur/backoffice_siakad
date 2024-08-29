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


Route::group(['middleware' => ['auth:hr']], function () {
    // get '/' to redirect to '/home'
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('/');

    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

    // route profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // jurusan
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index')->middleware(['permission:read_jurusan']);
    Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create')->middleware(['permission:create_jurusan']);
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store')->middleware(['permission:create_jurusan']);
    Route::get('/jurusan/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit')->middleware(['permission:update_jurusan']);
    Route::put('/jurusan/{jurusan}', [JurusanController::class, 'update'])->name('jurusan.update')->middleware(['permission:update_jurusan']);
    Route::delete('/jurusan/{jurusan}', [JurusanController::class, 'destroy'])->name('jurusan.destroy')->middleware(['permission:delete_jurusan']);
    // Route::get('/jurusan/show/{id}', [JurusanController::class, 'show'])->name('jurusan.show');

    // prodi
    Route::get('/prodi', [ProgramStudiController::class, 'index'])->name('prodi.index')->middleware(['permission:read_program_studi']);
    Route::get('/prodi/create', [ProgramStudiController::class, 'create'])->name('prodi.create')->middleware(['permission:create_program_studi']);
    Route::post('/prodi', [ProgramStudiController::class, 'store'])->name('prodi.store')->middleware(['permission:create_program_studi']);
    Route::get('/prodi/{prodi}/edit', [ProgramStudiController::class, 'edit'])->name('prodi.edit')->middleware(['permission:update_program_studi']);
    Route::put('/prodi/{prodi}', [ProgramStudiController::class, 'update'])->name('prodi.update')->middleware(['permission:update_program_studi']);
    Route::delete('/prodi/{prodi}', [ProgramStudiController::class, 'destroy'])->name('prodi.destroy')->middleware(['permission:delete_program_studi']);
    Route::get('/prodi/show/{id}', [ProgramStudiController::class, 'show'])->name('prodi.show')->middleware(['permission:read_program_studi']);


    // CRUD Mahasiswa
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index')->middleware(['permission:read_mahasiswa']);
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create')->middleware(['permission:create_mahasiswa']);
    Route::post('/mahasiswa', [MahasiswaController::class, 'storeOrUpdate'])->name('mahasiswa.store')->middleware(['permission:create_mahasiswa']);
    Route::get('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show'])->name('mahasiswa.show')->middleware(['permission:read_mahasiswa']);
    Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit')->middleware(['permission:update_mahasiswa']);
    Route::put('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'storeOrUpdate'])->name('mahasiswa.update')->middleware(['permission:update_mahasiswa']);
    Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy')->middleware(['permission:delete_mahasiswa']);

    // Bayar
    Route::post('/mahasiswa/bayar', [MahasiswaController::class, 'bayar'])->name('mahasiswa.bayar')->middleware(['permission:update_mahasiswa']);
    Route::get('/get-paket-matakuliah-details/{id}', [MahasiswaController::class, 'getPaketMatakuliahDetails'])->middleware(['permission:update_mahasiswa']);
    Route::get('/get-paket-matakuliah-by-semester', [MahasiswaController::class, 'getPaketMataKuliahBySemester'])->middleware(['permission:update_mahasiswa']);

    // ajax
    Route::get('/mahasiswa/cities/{provinceCode}', [MahasiswaController::class, 'getCities'])->middleware(['permission:read_mahasiswa']);
    Route::get('/mahasiswa/districts/{cityCode}', [MahasiswaController::class, 'getDistricts'])->middleware(['permission:read_mahasiswa']);
    Route::get('/mahasiswa/villages/{districtCode}', [MahasiswaController::class, 'getVillages'])->middleware(['permission:read_mahasiswa']);

    // ruang kelas
    Route::get('/ruang-kelas', [RuangKelasController::class, 'index'])->name('kelas.index')->middleware(['permission:read_ruang_kelas']);
    Route::get('/ruang-kelas/create', [RuangKelasController::class, 'create'])->name('kelas.create')->middleware(['permission:create_ruang_kelas']);
    Route::post('/ruang-kelas', [RuangKelasController::class, 'store'])->name('kelas.store')->middleware(['permission:create_ruang_kelas']);
    Route::get('/ruang-kelas/{kelas}/edit', [RuangKelasController::class, 'edit'])->name('kelas.edit')->middleware(['permission:update_ruang_kelas']);
    Route::put('/ruang-kelas/{kelas}', [RuangKelasController::class, 'update'])->name('kelas.update')->middleware(['permission:update_ruang_kelas']);
    Route::delete('/ruang-kelas/{kelas}', [RuangKelasController::class, 'destroy'])->name('kelas.destroy')->middleware(['permission:delete_ruang_kelas']);
    // Route::get('/ruang-kelas/show/{id}', [RuangKelasController::class, 'show'])->name('kelas.show');

    // tahun ajaran
    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun-ajaran.index')->middleware(['permission:read_tahun_ajaran']);
    Route::get('/tahun-ajaran/create', [TahunAjaranController::class, 'create'])->name('tahun-ajaran.create')->middleware(['permission:create_tahun_ajaran']);
    Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store')->middleware(['permission:create_tahun_ajaran']);
    Route::get('/tahun-ajaran/{tahunAjaran}/edit', [TahunAjaranController::class, 'edit'])->name('tahun-ajaran.edit')->middleware(['permission:update_tahun_ajaran']);
    Route::put('/tahun-ajaran/{tahunAjaran}', [TahunAjaranController::class, 'update'])->name('tahun-ajaran.update')->middleware(['permission:update_tahun_ajaran']);
    Route::delete('/tahun-ajaran/{tahunAjaran}', [TahunAjaranController::class, 'destroy'])->name('tahun-ajaran.destroy')->middleware(['permission:delete_tahun_ajaran']);

    // semester
    Route::get('/semester', [SemesterController::class, 'index'])->name('semester.index')->middleware(['permission:read_semester']);
    Route::get('/semester/create', [SemesterController::class, 'create'])->name('semester.create')->middleware(['permission:create_semester']);
    Route::post('/semester', [SemesterController::class, 'store'])->name('semester.store')->middleware(['permission:create_semester']);
    Route::get('/semester/{semester}/edit', [SemesterController::class, 'edit'])->name('semester.edit')->middleware(['permission:update_semester']);
    Route::put('/semester/{semester}', [SemesterController::class, 'update'])->name('semester.update')->middleware(['permission:update_semester']);
    Route::delete('/semester/{semester}', [SemesterController::class, 'destroy'])->name('semester.destroy')->middleware(['permission:delete_semester']);
    // Route::get('/semester/show/{id}', [SemesterController::class, 'show'])->name('semester.show');

    // Mata Kuliah
    Route::get('/mata-kuliah', [MataKuliahController::class, 'index'])->name('mata-kuliah.index')->middleware(['permission:read_mata_kuliah']);
    Route::get('/mata-kuliah/create', [MataKuliahController::class, 'create'])->name('mata-kuliah.create')->middleware(['permission:create_mata_kuliah']);
    Route::post('/mata-kuliah', [MataKuliahController::class, 'store'])->name('mata-kuliah.store')->middleware(['permission:create_mata_kuliah']);
    Route::get('/mata-kuliah/{matkul}/edit', [MataKuliahController::class, 'edit'])->name('mata-kuliah.edit')->middleware(['permission:update_mata_kuliah']);
    Route::put('/mata-kuliah/{matkul}', [MataKuliahController::class, 'update'])->name('mata-kuliah.update')->middleware(['permission:update_mata_kuliah']);
    Route::delete('/mata-kuliah/{matkul}', [MataKuliahController::class, 'destroy'])->name('mata-kuliah.destroy')->middleware(['permission:delete_mata_kuliah']);
    Route::get('/mata-kuliah/show/{id}', [MataKuliahController::class, 'show'])->name('mata-kuliah.show')->middleware(['permission:read_mata_kuliah']);

    //crud position
    Route::get('/position', [PositionController::class, 'index'])->name('position.index')->middleware(['permission:read_position']);
    Route::post('/position', [PositionController::class, 'store'])->name('position.store')->middleware(['permission:create_position']);
    Route::get('/position/{id}/edit', [PositionController::class, 'edit'])->name('position.edit')->middleware(['permission:update_position']);
    Route::put('/position/{id}', [PositionController::class, 'update'])->name('position.update')->middleware(['permission:update_position']);
    Route::delete('/position/{id}', [PositionController::class, 'destroy'])->name('position.destroy')->middleware(['permission:delete_position']);
    Route::get('/position/show/{id}', [PositionController::class, 'show'])->name('position.show')->middleware(['permission:read_position']);
    Route::get('/position/create', [PositionController::class, 'create'])->name('position.create')->middleware(['permission:create_position']);

    //crud hr
    Route::get('/hr', [HrController::class, 'index'])->name('hr.index')->middleware(['permission:read_hr']);
    Route::post('/hr', [HrController::class, 'store'])->name('hr.store')->middleware(['permission:create_hr']);
    Route::get('/hr/{id}/edit', [HrController::class, 'edit'])->name('hr.edit')->middleware(['permission:update_hr']);
    Route::put('/hr/{id}', [HrController::class, 'update'])->name('hr.update')->middleware(['permission:update_hr']);
    Route::delete('hr/{id}', [HrController::class, 'destroy'])->name('hr.destroy')->middleware(['permission:delete_hr']);
    Route::get('/hr/show/{id}', [HrController::class, 'show'])->name('hr.show')->middleware(['permission:read_hr']);
    Route::get('/hr/create', [HrController::class, 'create'])->name('hr.create')->middleware(['permission:create_hr']);


    Route::get('/paket-matakuliah', [PaketMataKuliahController::class, 'index'])->name('paket-matakuliah.index')->middleware(['permission:read_paket_mata_kuliah']);
    Route::get('/paket-matakuliah/create', [PaketMataKuliahController::class, 'create'])->name('paket-matakuliah.create')->middleware(['permission:create_paket_mata_kuliah']);
    Route::post('/paket-matakuliah', [PaketMataKuliahController::class, 'store'])->name('paket-matakuliah.store')->middleware(['permission:create_paket_mata_kuliah']);
    Route::get('/paket-matakuliah/show/{id}', [PaketMataKuliahController::class, 'show'])->name('paket-matakuliah.show')->middleware(['permission:read_paket_mata_kuliah']);
    Route::get('/paket-matakuliah/{id}/edit', [PaketMataKuliahController::class, 'edit'])->name('paket-matakuliah.edit')->middleware(['permission:update_paket_mata_kuliah']);
    Route::put('/paket-matakuliah/{id}', [PaketMataKuliahController::class, 'update'])->name('paket-matakuliah.update')->middleware(['permission:update_paket_mata_kuliah']);
    Route::delete('/paket-matakuliah/{id}', [PaketMataKuliahController::class, 'destroy'])->name('paket-matakuliah.destroy')->middleware(['permission:delete_paket_mata_kuliah']);

    // Route untuk mengambil mata kuliah berdasarkan program studi dan semester
    Route::get('/paket-matakuliah/get-matakuliah/{programStudiId}/{semester}', [PaketMataKuliahController::class, 'getMataKuliah'])->name('get-matakuliah')->middleware(['permission:read_paket_mata_kuliah']);

    //crud berita
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index')->middleware(['permission:read_berita']);
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create')->middleware(['permission:create_berita']);
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store')->middleware(['permission:create_berita']);
    Route::get('/berita/show/{id}', [BeritaController::class, 'show'])->name('berita.show')->middleware(['permission:read_berita']);
    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit')->middleware(['permission:update_berita']);
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update')->middleware(['permission:update_berita']);
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy')->middleware(['permission:delete_berita']);

    // paket jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index')->middleware(['permission:read_jadwal']);
    Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create')->middleware(['permission:create_jadwal']);
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store')->middleware(['permission:create_jadwal']);
    Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit')->middleware(['permission:update_jadwal']);
    Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update')->middleware(['permission:update_jadwal']);
    Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy')->middleware(['permission:delete_jadwal']);
    Route::get('/jadwal/show/{id}', [JadwalController::class, 'show'])->name('jadwal.show')->middleware(['permission:read_jadwal']);
    Route::get('/jadwal/details/{paketMataKuliah}', [JadwalController::class, 'getPaketDetails'])->middleware(['permission:read_jadwal']);

    Route::get('/nilai/create', [NilaiController::class, 'index'])->name('nilai');

    Route::get('/nilai/getMahasiswaByMatakuliah', [NilaiController::class, 'getMahasiswaByMatakuliah']);
});

//login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/loginFrom', [LoginController::class, 'generateLoginURL'])->name('login.generateURL');
Route::get('/prosesLogin/{hp}/{otp}', [LoginController::class, 'prosesLogin'])->name('login.processLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
