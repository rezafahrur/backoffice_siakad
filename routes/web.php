<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RuangKelasController;
use App\Http\Controllers\SkalaNilaiController;
use App\Http\Controllers\EvaluasiPlanController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\PaketMataKuliahController;
use App\Http\Controllers\PembelajaranPlanController;
use App\Http\Controllers\PeriodePerkuliahanController;
use App\Http\Controllers\MasterFeatureController;
use App\Http\Controllers\MoodleAuthController;
use App\Models\MasterFeature;

Route::group(['middleware' => ['auth:hr']], function () {
    // get '/' to redirect to '/home'
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('/');

    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/mahasiswa/status', [DashboardController::class, 'getMahasiswaStatus']);
    Route::get('/periode-perkuliahan/chart-data', [PeriodePerkuliahanController::class, 'chartData']);


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
    Route::get('/mahasiswa/export', [MahasiswaController::class, 'export'])->name('mahasiswa.export')->middleware(['permission:read_mahasiswa']);
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create')->middleware(['permission:create_mahasiswa']);
    Route::post('/mahasiswa', [MahasiswaController::class, 'storeOrUpdate'])->name('mahasiswa.store')->middleware(['permission:create_mahasiswa']);
    Route::post('/mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import')->middleware(['permission:create_mahasiswa']);
    Route::get('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show'])->name('mahasiswa.show')->middleware(['permission:read_mahasiswa']);
    Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit')->middleware(['permission:update_mahasiswa']);
    Route::put('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'storeOrUpdate'])->name('mahasiswa.update')->middleware(['permission:update_mahasiswa']);
    Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy')->middleware(['permission:delete_mahasiswa']);
    Route::post('/mahasiswa/quickAdd', [MahasiswaController::class, 'quickAdd'])->name('mahasiswa.quickAdd')->middleware(['permission:create_mahasiswa']);

    // Bayar
    Route::post('/mahasiswa/bayar', [MahasiswaController::class, 'bayar'])->name('mahasiswa.bayar')->middleware(['permission:update_mahasiswa']);
    Route::get('/get-kurikulum-details/{id}', [MahasiswaController::class, 'getKurikulumDetails'])->middleware(['permission:update_mahasiswa']);
    Route::get('/get-kurikulum-by-semester', [MahasiswaController::class, 'getKurikulumBySemester'])->middleware(['permission:update_mahasiswa']);

    // ajax
    Route::get('/mahasiswa/cities/{provinceCode}', [MahasiswaController::class, 'getCities'])->middleware(['permission:read_mahasiswa']);
    Route::get('/mahasiswa/districts/{cityCode}', [MahasiswaController::class, 'getDistricts'])->middleware(['permission:read_mahasiswa']);
    Route::get('/mahasiswa/villages/{districtCode}', [MahasiswaController::class, 'getVillages'])->middleware(['permission:read_mahasiswa']);

    // ruang kelas
    Route::get('/classroom', [RuangKelasController::class, 'index'])->name('ruang-kelas.index')->middleware(['permission:read_ruang_kelas']);
    Route::get('/classroom/create', [RuangKelasController::class, 'create'])->name('ruang-kelas.create')->middleware(['permission:create_ruang_kelas']);
    Route::post('/classroom', [RuangKelasController::class, 'store'])->name('ruang-kelas.store')->middleware(['permission:create_ruang_kelas']);
    Route::get('/classroom/{kelas}/edit', [RuangKelasController::class, 'edit'])->name('ruang-kelas.edit')->middleware(['permission:update_ruang_kelas']);
    Route::put('/classroom/{kelas}', [RuangKelasController::class, 'update'])->name('ruang-kelas.update')->middleware(['permission:update_ruang_kelas']);
    Route::delete('/classroom/{kelas}', [RuangKelasController::class, 'destroy'])->name('ruang-kelas.destroy')->middleware(['permission:delete_ruang_kelas']);
    // Route::get('/ruang-kelas/show/{id}', [RuangKelasController::class, 'show'])->name('kelas.show');

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

    // prestasi
    Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index')->middleware(['permission:read_prestasi']);
    Route::get('/prestasi/create', [PrestasiController::class, 'create'])->name('prestasi.create')->middleware(['permission:create_prestasi']);
    Route::post('/prestasi', [PrestasiController::class, 'store'])->name('prestasi.store')->middleware(['permission:create_prestasi']);
    Route::get('/prestasi/{prestasi}/edit', [PrestasiController::class, 'edit'])->name('prestasi.edit')->middleware(['permission:update_prestasi']);
    Route::put('/prestasi/{prestasi}', [PrestasiController::class, 'update'])->name('prestasi.update')->middleware(['permission:update_prestasi']);
    Route::delete('/prestasi/{prestasi}', [PrestasiController::class, 'destroy'])->name('prestasi.destroy')->middleware(['permission:delete_prestasi']);
    Route::get('/prestasi/show/{id}', [PrestasiController::class, 'show'])->name('prestasi.show')->middleware(['permission:read_prestasi']);
    Route::get('/getMahasiswaByProdi', [PrestasiController::class, 'getMahasiswaByProdi'])->name('getMahasiswaByProdi');

    //kuriukulum
    Route::get('/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum.index')->middleware(['permission:read_kurikulum']);
    Route::get('/kurikulum/export', [KurikulumController::class, 'export'])->name('kurikulum.export');
    Route::get('/kurikulum/create', [KurikulumController::class, 'create'])->name('kurikulum.create')->middleware(['permission:create_kurikulum']);
    Route::post('/kurikulum', [KurikulumController::class, 'store'])->name('kurikulum.store')->middleware(['permission:create_kurikulum']);
    Route::get('/kurikulum/{kurikulum}/edit', [KurikulumController::class, 'edit'])->name('kurikulum.edit')->middleware(['permission:update_kurikulum']);
    Route::put('/kurikulum/{kurikulum}', [KurikulumController::class, 'update'])->name('kurikulum.update')->middleware(['permission:update_kurikulum']);
    Route::delete('/kurikulum/{kurikulum}', [KurikulumController::class, 'destroy'])->name('kurikulum.destroy')->middleware(['permission:delete_kurikulum']);
    Route::get('/kurikulum/show/{id}', [KurikulumController::class, 'show'])->name('kurikulum.show')->middleware(['permission:read_kurikulum']);

    //kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index')->middleware(['permission:read_kelas']);
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create')->middleware(['permission:create_kelas']);
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store')->middleware(['permission:create_kelas']);
    Route::get('/kelas/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit')->middleware(['permission:update_kelas']);
    Route::put('/kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update')->middleware(['permission:update_kelas']);
    Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy')->middleware(['permission:delete_kelas']);
    Route::get('/kelas/show/{id}', [KelasController::class, 'show'])->name('kelas.show')->middleware(['permission:read_kelas']);
    Route::get('/kelas/details/{kurikulum}', [KelasController::class, 'getKurikulumDetails'])->name('kelas.details');

    //periode perkuliahan
    Route::get('/periode-perkuliahan', [PeriodePerkuliahanController::class, 'index'])->name('periode-perkuliahan.index');
    Route::get('/periode-perkuliahan/create', [PeriodePerkuliahanController::class, 'create'])->name('periode-perkuliahan.create');
    Route::post('/periode-perkuliahan', [PeriodePerkuliahanController::class, 'store'])->name('periode-perkuliahan.store');
    Route::get('/periode-perkuliahan/{id}/edit', [PeriodePerkuliahanController::class, 'edit'])->name('periode-perkuliahan.edit');
    Route::put('/periode-perkuliahan/{id}', [PeriodePerkuliahanController::class, 'update'])->name('periode-perkuliahan.update');
    Route::delete('/periode-perkuliahan/{id}', [PeriodePerkuliahanController::class, 'destroy'])->name('periode-perkuliahan.destroy');
    Route::get('/periode-perkuliahan/show/{id}', [PeriodePerkuliahanController::class, 'show'])->name('periode-perkuliahan.show');

    // Route untuk mengambil mata kuliah berdasarkan program studi dan semester
    Route::get('/kurikulum/get-matakuliah/{prodi}/{semester}', [KurikulumController::class, 'getMataKuliah'])->name('get-matakuliah');
    Route::post('/kurikulum/get-matakuliah-details', [KurikulumController::class, 'getMataKuliahDetails']);

    // Route::put('/tahun-akademik/{id}', [TahunAkademikController::class, 'update'])->name('tahun-akademik.update');
    Route::get('/config', [ConfigController::class, 'index'])->name('config.index');
    Route::post('/config', [ConfigController::class, 'update'])->name('config.update');

    // skala-nilai
    Route::get('/skala-nilai', [SkalaNilaiController::class, 'index'])->name('skala-nilai.index');
    Route::get('/skala-nilai/create', [SkalaNilaiController::class, 'create'])->name('skala-nilai.create');
    Route::post('/skala-nilai', [SkalaNilaiController::class, 'store'])->name('skala-nilai.store');
    Route::get('/skala-nilai/{skalaNilai}/edit', [SkalaNilaiController::class, 'edit'])->name('skala-nilai.edit');
    Route::put('/skala-nilai/{skalaNilai}', [SkalaNilaiController::class, 'update'])->name('skala-nilai.update');
    Route::delete('/skala-nilai/{skalaNilai}', [SkalaNilaiController::class, 'destroy'])->name('skala-nilai.destroy');
    Route::get('/skala-nilai/show/{id}', [SkalaNilaiController::class, 'show'])->name('skala-nilai.show');

    // pembelajaran plan
    Route::get('/rps', [PembelajaranPlanController::class, 'index'])->name('pembelajaran_plans.index');
    Route::get('/rps/export', [PembelajaranPlanController::class, 'export'])->name('pembelajaran_plans.export');
    Route::get('/rps/create', [PembelajaranPlanController::class, 'create'])->name('pembelajaran_plans.create');
    Route::post('/rps', [PembelajaranPlanController::class, 'store'])->name('pembelajaran_plans.store');
    Route::get('/rps/{pembelajaranPlan}/edit', [PembelajaranPlanController::class, 'edit'])->name('pembelajaran_plans.edit');
    Route::put('/rps/{pembelajaranPlan}', [PembelajaranPlanController::class, 'update'])->name('pembelajaran_plans.update');
    Route::delete('/rps/{pembelajaranPlan}', [PembelajaranPlanController::class, 'destroy'])->name('pembelajaran_plans.destroy');
    Route::get('/rps/show/{id}', [PembelajaranPlanController::class, 'show'])->name('pembelajaran_plans.show');
    Route::get('/api/get-program-studi/{matakuliahId}', [PembelajaranPlanController::class, 'getProgramStudi']);

    // evaluasi plan
    Route::get('/evaluasi-plan', [EvaluasiPlanController::class, 'index'])->name('evaluasi_plan.index');
    Route::get('/evaluasi-plan/export', [EvaluasiPlanController::class, 'export'])->name('evaluasi_plan.export');
    Route::get('/evaluasi-plan/create', [EvaluasiPlanController::class, 'create'])->name('evaluasi_plan.create');
    Route::post('/evaluasi-plan', [EvaluasiPlanController::class, 'store'])->name('evaluasi_plan.store');
    Route::get('/evaluasi-plan/{evaluasiPlan}/edit', [EvaluasiPlanController::class, 'edit'])->name('evaluasi_plan.edit');
    Route::put('/evaluasi-plan/{evaluasiPlan}', [EvaluasiPlanController::class, 'update'])->name('evaluasi_plan.update');
    Route::delete('/evaluasi-plan/{evaluasiPlan}', [EvaluasiPlanController::class, 'destroy'])->name('evaluasi_plan.destroy');
    Route::get('/evaluasi-plan/show/{id}', [EvaluasiPlanController::class, 'show'])->name('evaluasi_plan.show');
    Route::get('/evaluasi-plan/get-program-studi/{matakuliahId}', [EvaluasiPlanController::class, 'getProgramStudi']);

    Route::get('/feature', [MasterFeatureController::class, 'index'])->name('feature.index');
    Route::get('/feature/create', [MasterFeatureController::class, 'create'])->name('feature.create');
    Route::post('/feature', [MasterFeatureController::class, 'store'])->name('feature.store');
    Route::get('/feature/{id}/edit', [MasterFeatureController::class, 'edit'])->name('feature.edit');
    Route::put('/feature/{id}', [MasterFeatureController::class, 'update'])->name('feature.update');
    Route::delete('/feature/{id}', [MasterFeatureController::class, 'destroy'])->name('feature.destroy');


    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::get('/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
    Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
    Route::get('/nilai/{nilai}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
    Route::put('/nilai/{nilai}', [NilaiController::class, 'update'])->name('nilai.update');
    Route::delete('/nilai/{nilai}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
    Route::get('/nilai/show/{id}', [NilaiController::class, 'show'])->name('nilai.show');
    // Rute untuk AJAX
    Route::get('/nilai/getKelasMataKuliah/{programStudiId}', [NilaiController::class, 'getKelasMataKuliah']);
    // get mahaasiswa
    Route::get('/nilai/get-mahasiswa/{kelasId}', [NilaiController::class, 'getMahasiswaByKelas']);

    Route::get('/moodle-login', [MoodleAuthController::class, 'showLoginForm'])->name('moodle.login.form');
    Route::post('/moodle-login', [MoodleAuthController::class, 'loginToMoodle'])->name('moodle.login');
});



//login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/loginFrom', [LoginController::class, 'generateLoginURL'])->name('login.generateURL');
Route::get('/prosesLogin/{hp}/{otp}', [LoginController::class, 'prosesLogin'])->name('login.processLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
