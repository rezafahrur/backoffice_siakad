<?php

use App\Models\MasterFeature;
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
use App\Http\Controllers\MoodleAuthController;
use App\Http\Controllers\RuangKelasController;
use App\Http\Controllers\SkalaNilaiController;
use App\Http\Controllers\JadwalUjianController;
use App\Http\Controllers\EvaluasiPlanController;
use App\Http\Controllers\MahasiswaKtmController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\MasterFeatureController;
use App\Http\Controllers\JadwalSementaraController;
use App\Http\Controllers\PaketMataKuliahController;
use App\Http\Controllers\PembelajaranPlanController;
use App\Http\Controllers\KuisionerAkademikController;
use App\Http\Controllers\AktivitasMahasiswaController;
use App\Http\Controllers\PeriodePerkuliahanController;
use App\Http\Controllers\MahasiswaRequestSuratController;
use App\Http\Controllers\AktivitasMahasiswaBimbingController;
use App\Http\Controllers\AktivitasMahasiswaPesertaController;
use App\Http\Controllers\SpmbPendaftarController;
use App\Http\Controllers\SpmbPengumumanController;
use App\Http\Controllers\ApiController;

Route::group(['middleware' => ['auth:hr']], function () {
    // get '/' to redirect to '/home'
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('/');

    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/mahasiswa/status', [DashboardController::class, 'getMahasiswaStatus']);
    Route::get('/periode-perkuliahan/chart-data', [PeriodePerkuliahanController::class, 'chartData']);

    Route::post('/getToken', [ApiController::class, 'getToken'])->name('getToken');

    // route profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // route prefix mahasiswa
    Route::prefix('mhs')->group(function () {
        // CRUD Mahasiswa
        Route::get('/data', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/data/export', [MahasiswaController::class, 'export'])->name('mahasiswa.export');
        Route::get('/data/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/data', [MahasiswaController::class, 'storeOrUpdate'])->name('mahasiswa.store');
        Route::post('/data/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');
        Route::get('/data/{mahasiswa}/show', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
        Route::get('/data/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/data/{mahasiswa}', [MahasiswaController::class, 'storeOrUpdate'])->name('mahasiswa.update');
        Route::delete('/data/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
        Route::post('/data/quickAdd', [MahasiswaController::class, 'quickAdd'])->name('mahasiswa.quickAdd');
        Route::post('/data/bayar', [MahasiswaController::class, 'bayar'])->name('mahasiswa.bayar');

        // CRUD Mahasiswa KTM
        Route::get('/ktm-validasi', [MahasiswaKtmController::class, 'index'])->name('ktm-validasi.index');
        Route::post('/ktm-validasi/update-status/{id}', [MahasiswaKtmController::class, 'updateStatus'])->name('ktm-validasi.update-status');
        Route::post('/ktm-validasi/validate/{id}', [MahasiswaKtmController::class, 'validateKtm'])->name('ktm-validasi.validate');
        Route::post('/ktm-validasi/reject/{id}', [MahasiswaKtmController::class, 'rejectKtm'])->name('ktm-validasi.reject');
        Route::delete('/ktm-validasi/{id}', [MahasiswaKtmController::class, 'deleteKtm'])->name('ktm-validasi.delete');

        // CRUD Mahasiswa SPBM
        Route::get('/spmb', [SpmbPendaftarController::class, 'index'])->name('spmb.index');
        Route::put('/spmb/update-status/{id}', [SpmbPendaftarController::class, 'updateStatus'])->name('spmb.update-status');
        Route::put('/spmb/validasi/{id}', [SpmbPendaftarController::class, 'validate'])->name('spmb.validate');
        Route::put('/spmb/reject/{id}', [SpmbPendaftarController::class, 'rejectPendaftar'])->name('spmb.reject');
        Route::delete('/spmb/{id}', [SpmbPendaftarController::class, 'destroy'])->name('spmb.destroy');
        Route::get('/spmb/export-pdf', [SpmbPendaftarController::class, 'exportAllPDF'])->name('spmb.exportPDF');

        // CRUD Mahasiswa SPMB Pengumuman
        Route::prefix('spmb_pengumuman')->group(function () {
            Route::get('/', [SpmbPengumumanController::class, 'index'])->name('spmb_pengumuman.index');
            Route::get('/create', [SpmbPengumumanController::class, 'create'])->name('spmb_pengumuman.create');
            Route::post('/', [SpmbPengumumanController::class, 'store'])->name('spmb_pengumuman.store');
            Route::delete('/{id}', [SpmbPengumumanController::class, 'destroy'])->name('spmb_pengumuman.destroy');
            Route::get('/{id}/edit', [SpmbPengumumanController::class, 'edit'])->name('spmb_pengumuman.edit');
            Route::put('/{id}', [SpmbPengumumanController::class, 'update'])->name('spmb_pengumuman.update');
        });
    });

    Route::get('/get-kurikulum-details/{id}', [MahasiswaController::class, 'getKurikulumDetails'])->middleware(['permission:update_mahasiswa']);
    Route::get('/get-kurikulum-by-semester', [MahasiswaController::class, 'getKurikulumBySemester'])->middleware(['permission:update_mahasiswa']);

    // ajax
    Route::get('/mahasiswa/cities/{provinceCode}', [MahasiswaController::class, 'getCities'])->middleware(['permission:read_mahasiswa']);
    Route::get('/mahasiswa/districts/{cityCode}', [MahasiswaController::class, 'getDistricts'])->middleware(['permission:read_mahasiswa']);
    Route::get('/mahasiswa/villages/{districtCode}', [MahasiswaController::class, 'getVillages'])->middleware(['permission:read_mahasiswa']);

    //crud hr
    Route::get('/hr', [HrController::class, 'index'])->name('hr.index')->middleware(['permission:read_hr']);
    Route::post('/hr', [HrController::class, 'store'])->name('hr.store')->middleware(['permission:create_hr']);
    Route::get('/hr/{id}/edit', [HrController::class, 'edit'])->name('hr.edit')->middleware(['permission:update_hr']);
    Route::put('/hr/{id}', [HrController::class, 'update'])->name('hr.update')->middleware(['permission:update_hr']);
    Route::delete('hr/{id}', [HrController::class, 'destroy'])->name('hr.destroy')->middleware(['permission:delete_hr']);
    Route::get('/hr/{id}/show', [HrController::class, 'show'])->name('hr.show')->middleware(['permission:read_hr']);
    Route::get('/hr/create', [HrController::class, 'create'])->name('hr.create')->middleware(['permission:create_hr']);
    Route::get('/hr/download-template', [HrController::class, 'downloadTemplate'])->name('hr.download-template');
    Route::post('/hr/import', [HrController::class, 'import'])->name('hr.import')->middleware(['permission:create_hr']);

    Route::prefix('master')->group(function () {
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

        // ruang kelas
        Route::get('/ruang-kelas', [RuangKelasController::class, 'index'])->name('ruang-kelas.index')->middleware(['permission:read_ruang_kelas']);
        Route::get('/ruang-kelas/create', [RuangKelasController::class, 'create'])->name('ruang-kelas.create')->middleware(['permission:create_ruang_kelas']);
        Route::post('/ruang-kelas', [RuangKelasController::class, 'store'])->name('ruang-kelas.store')->middleware(['permission:create_ruang_kelas']);
        Route::get('/ruang-kelas/{kelas}/edit', [RuangKelasController::class, 'edit'])->name('ruang-kelas.edit')->middleware(['permission:update_ruang_kelas']);
        Route::put('/ruang-kelas/{kelas}', [RuangKelasController::class, 'update'])->name('ruang-kelas.update')->middleware(['permission:update_ruang_kelas']);
        Route::delete('/ruang-kelas/{kelas}', [RuangKelasController::class, 'destroy'])->name('ruang-kelas.destroy')->middleware(['permission:delete_ruang_kelas']);
        Route::get('/ruang-kelas/show/{id}', [RuangKelasController::class, 'show'])->name('ruang-kelas.show')->middleware(['permission:read_ruang_kelas']);

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
        Route::get('/mata-kuliah/{id}/show', [MataKuliahController::class, 'show'])->name('mata-kuliah.show')->middleware(['permission:read_mata_kuliah']);

        //crud position
        Route::get('/position', [PositionController::class, 'index'])->name('position.index')->middleware(['permission:read_position']);
        Route::post('/position', [PositionController::class, 'store'])->name('position.store')->middleware(['permission:create_position']);
        Route::get('/position/{id}/edit', [PositionController::class, 'edit'])->name('position.edit')->middleware(['permission:update_position']);
        Route::put('/position/{id}', [PositionController::class, 'update'])->name('position.update')->middleware(['permission:update_position']);
        Route::delete('/position/{id}', [PositionController::class, 'destroy'])->name('position.destroy')->middleware(['permission:delete_position']);
        Route::get('/position/{id}/show', [PositionController::class, 'show'])->name('position.show')->middleware(['permission:read_position']);
        Route::get('/position/create', [PositionController::class, 'create'])->name('position.create')->middleware(['permission:create_position']);
    });

    // Kurikulum Routes
    Route::prefix('kurikulum')->group(function () {
        Route::get('/matkul', [KurikulumController::class, 'index'])->name('kurikulum.index')->middleware(['permission:read_kurikulum']);
        Route::get('/matkul/export', [KurikulumController::class, 'export'])->name('kurikulum.export');
        Route::get('/matkul/create', [KurikulumController::class, 'create'])->name('kurikulum.create')->middleware(['permission:create_kurikulum']);
        Route::post('/matkul', [KurikulumController::class, 'store'])->name('kurikulum.store')->middleware(['permission:create_kurikulum']);
        Route::get('/matkul/{kurikulum}/edit', [KurikulumController::class, 'edit'])->name('kurikulum.edit')->middleware(['permission:update_kurikulum']);
        Route::put('/matkul/{kurikulum}', [KurikulumController::class, 'update'])->name('kurikulum.update')->middleware(['permission:update_kurikulum']);
        Route::delete('/matkul/{kurikulum}', [KurikulumController::class, 'destroy'])->name('kurikulum.destroy')->middleware(['permission:delete_kurikulum']);
        Route::get('/matkul/{id}/show', [KurikulumController::class, 'show'])->name('kurikulum.show')->middleware(['permission:read_kurikulum']);

        // Rencana Pembelajaran Routes
        Route::get('/rencana-pembelajaran', [PembelajaranPlanController::class, 'index'])->name('pembelajaran_plans.index');
        Route::get('/rencana-pembelajaran/export', [PembelajaranPlanController::class, 'export'])->name('pembelajaran_plans.export');
        Route::get('/rencana-pembelajaran/create', [PembelajaranPlanController::class, 'create'])->name('pembelajaran_plans.create');
        Route::post('/rencana-pembelajaran', [PembelajaranPlanController::class, 'store'])->name('pembelajaran_plans.store');
        Route::get('/rencana-pembelajaran/{pembelajaranPlan}/edit', [PembelajaranPlanController::class, 'edit'])->name('pembelajaran_plans.edit');
        Route::put('/rencana-pembelajaran/{pembelajaranPlan}', [PembelajaranPlanController::class, 'update'])->name('pembelajaran_plans.update');
        Route::delete('/rencana-pembelajaran/{pembelajaranPlan}', [PembelajaranPlanController::class, 'destroy'])->name('pembelajaran_plans.destroy');
        Route::get('/rencana-pembelajaran/{id}/show', [PembelajaranPlanController::class, 'show'])->name('pembelajaran_plans.show');
        Route::get('/rencana-pembelajaran/get-program-studi/{matakuliahId}', [PembelajaranPlanController::class, 'getProgramStudi']);

        // Rencana Evaluasi Routes
        Route::get('/rencana-evaluasi', [EvaluasiPlanController::class, 'index'])->name('evaluasi_plan.index');
        Route::get('/rencana-evaluasi/export', [EvaluasiPlanController::class, 'export'])->name('evaluasi_plan.export');
        Route::get('/rencana-evaluasi/create', [EvaluasiPlanController::class, 'create'])->name('evaluasi_plan.create');
        Route::post('/rencana-evaluasi', [EvaluasiPlanController::class, 'store'])->name('evaluasi_plan.store');
        Route::get('/rencana-evaluasi/{evaluasiPlan}/edit', [EvaluasiPlanController::class, 'edit'])->name('evaluasi_plan.edit');
        Route::put('/rencana-evaluasi/{evaluasiPlan}', [EvaluasiPlanController::class, 'update'])->name('evaluasi_plan.update');
        Route::delete('/rencana-evaluasi/{evaluasiPlan}', [EvaluasiPlanController::class, 'destroy'])->name('evaluasi_plan.destroy');
        Route::get('/rencana-evaluasi/{id}/show', [EvaluasiPlanController::class, 'show'])->name('evaluasi_plan.show');
        Route::get('/rencana-evaluasi/get-program-studi/{matakuliahId}', [EvaluasiPlanController::class, 'getProgramStudi']);
    });

    Route::prefix('feature')->group(function () {
        //crud berita
        Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index')->middleware(['permission:read_berita']);
        Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create')->middleware(['permission:create_berita']);
        Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store')->middleware(['permission:create_berita']);
        Route::get('/berita/{id}/show', [BeritaController::class, 'show'])->name('berita.show')->middleware(['permission:read_berita']);
        Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit')->middleware(['permission:update_berita']);
        Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update')->middleware(['permission:update_berita']);
        Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy')->middleware(['permission:delete_berita']);

        // Route::put('/tahun-akademik/{id}', [TahunAkademikController::class, 'update'])->name('tahun-akademik.update');
        Route::get('/config', [ConfigController::class, 'index'])->name('config.index');
        Route::post('/config', [ConfigController::class, 'update'])->name('config.update');

        Route::get('/fitur-hak-akses', [MasterFeatureController::class, 'index'])->name('feature.index');
        Route::get('/fitur-hak-akses/create', [MasterFeatureController::class, 'create'])->name('feature.create');
        Route::post('/fitur-hak-akses', [MasterFeatureController::class, 'store'])->name('feature.store');
        Route::get('/fitur-hak-akses/{id}/edit', [MasterFeatureController::class, 'edit'])->name('feature.edit');
        Route::put('/fitur-hak-akses/{id}', [MasterFeatureController::class, 'update'])->name('feature.update');
        Route::delete('/fitur-hak-akses/{id}', [MasterFeatureController::class, 'destroy'])->name('feature.destroy');

        // // jadwal sementara
        // Route::get('/file-jadwal', [JadwalSementaraController::class, 'index'])->name('jadwal-sementara.index');
        // Route::get('/file-jadwal/create', [JadwalSementaraController::class, 'create'])->name('jadwal-sementara.create');
        // Route::post('/file-jadwal', [JadwalSementaraController::class, 'store'])->name('jadwal-sementara.store');
        // Route::get('/file-jadwal/{jadwalSementara}/edit', [JadwalSementaraController::class, 'edit'])->name('jadwal-sementara.edit');
        // Route::put('/file-jadwal/{jadwalSementara}', [JadwalSementaraController::class, 'update'])->name('jadwal-sementara.update');
        // Route::delete('/file-jadwal/{jadwalSementara}', [JadwalSementaraController::class, 'destroy'])->name('jadwal-sementara.destroy');
    });

    Route::prefix('surat')->group(function () {

        // CRUD Mahasiswa Request Surat
        Route::get('/permintaan-surat', [MahasiswaRequestSuratController::class, 'index'])->name('permintaan-surat.index');
        Route::get('/permintaan-surat/{id}', [MahasiswaRequestSuratController::class, 'show'])->name('permintaan-surat.show');
        Route::post('/permintaan-surat/{id}/proses', [MahasiswaRequestSuratController::class, 'proses'])->name('permintaan-surat.proses');
        Route::delete('/permintaan-surat/{id}', [MahasiswaRequestSuratController::class, 'destroy'])->name('permintaan-surat.destroy');
    });

    // buatkan saya route prefix untuk kuisioner
    Route::prefix('kuisioner')->group(function () {
        Route::get('/kuisioner-akademik', [KuisionerAkademikController::class, 'index'])->name('kuisioner-akademik.index');
        Route::post('/kuisioner-akademik', [KuisionerAkademikController::class, 'store'])->name('kuisioner-akademik.store');
        Route::put('/kuisioner-akademik/{id}', [KuisionerAkademikController::class, 'update'])->name('kuisioner-akademik.update');
        Route::delete('/kuisioner-akademik/{id}', [KuisionerAkademikController::class, 'destroy'])->name('kuisioner-akademik.destroy');
    });

    Route::prefix('akm')->group(function (){
        // aktivitas mahasiswa
        Route::get('/aktivitas-mahasiswa', [AktivitasMahasiswaController::class, 'index'])->name('aktivitas.index');
        Route::get('/aktivitas-mahasiswa/export', [AktivitasMahasiswaController::class, 'export'])->name('aktivitas.export');
        Route::get('/aktivitas-mahasiswa/create', [AktivitasMahasiswaController::class, 'create'])->name('aktivitas.create');
        Route::post('/aktivitas-mahasiswa/store', [AktivitasMahasiswaController::class, 'store'])->name('aktivitas.store');
        Route::get('/aktivitas-mahasiswa/{id}/edit', [AktivitasMahasiswaController::class, 'edit'])->name('aktivitas.edit');
        Route::put('/aktivitas-mahasiswa/{id}', [AktivitasMahasiswaController::class, 'update'])->name('aktivitas.update');
        Route::get('/aktivitas-mahasiswa/{id}/show', [AktivitasMahasiswaController::class, 'show'])->name('aktivitas.show');
        Route::delete('/aktivitas-mahasiswa/{id}', [AktivitasMahasiswaController::class, 'destroy'])->name('aktivitas.destroy');

        // aktivitas mahasiswa peserta
        Route::get('/aktivitas-peserta', [AktivitasMahasiswaPesertaController::class, 'index'])->name('aktivitas-peserta.index');
        Route::get('/aktivitas-peserta/export', [AktivitasMahasiswaPesertaController::class, 'export'])->name('aktivitas-peserta.export');
        Route::get('/aktivitas-peserta/create', [AktivitasMahasiswaPesertaController::class, 'create'])->name('aktivitas-peserta.create');
        Route::post('/aktivitas-peserta/store', [AktivitasMahasiswaPesertaController::class, 'store'])->name('aktivitas-peserta.store');
        Route::get('/aktivitas-peserta/{id}/edit', [AktivitasMahasiswaPesertaController::class, 'edit'])->name('aktivitas-peserta.edit');
        Route::put('/aktivitas-peserta/{id}', [AktivitasMahasiswaPesertaController::class, 'update'])->name('aktivitas-peserta.update');
        Route::get('/aktivitas-peserta/{id}/show', [AktivitasMahasiswaPesertaController::class, 'show'])->name('aktivitas-peserta.show');
        Route::delete('/aktivitas-peserta/{id}', [AktivitasMahasiswaPesertaController::class, 'destroy'])->name('aktivitas-peserta.destroy');

        // aktivitas mahasiswa bimbing uji
        Route::get('/aktivitas-bimbing-uji', [AktivitasMahasiswaBimbingController::class, 'index'])->name('bimbingUji.index');
        Route::get('/aktivitas-bimbing-uji/create', [AktivitasMahasiswaBimbingController::class, 'create'])->name('bimbingUji.create');
        Route::get('/aktivitas-bimbing-uji/export', [AktivitasMahasiswaBimbingController::class, 'export'])->name('bimbingUji.export');
        Route::post('/aktivitas-bimbing-uji/store', [AktivitasMahasiswaBimbingController::class, 'store'])->name('bimbingUji.store');
        Route::get('/aktivitas-bimbing-uji/{id}/edit', [AktivitasMahasiswaBimbingController::class, 'edit'])->name('bimbingUji.edit');
        Route::put('/aktivitas-bimbing-uji/{id}', [AktivitasMahasiswaBimbingController::class, 'update'])->name('bimbingUji.update');
        Route::get('/aktivitas-bimbing-uji/{id}/show', [AktivitasMahasiswaBimbingController::class, 'show'])->name('bimbingUji.show');
        Route::delete('/aktivitas-bimbing-uji/{id}', [AktivitasMahasiswaBimbingController::class, 'destroy'])->name('bimbingUji.destroy');
    });

    // prefix Perkuliahan
    Route::prefix('kuliah')->group(function () {
        // paket jadwal

        // Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index')->middleware(['permission:read_jadwal']);
        // Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create')->middleware(['permission:create_jadwal']);
        // Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store')->middleware(['permission:create_jadwal']);
        // Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit')->middleware(['permission:update_jadwal']);
        // Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update')->middleware(['permission:update_jadwal']);
        // Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy')->middleware(['permission:delete_jadwal']);
        // Route::get('/jadwal/{id}/show', [JadwalController::class, 'show'])->name('jadwal.show')->middleware(['permission:read_jadwal']);

        // jadwal sementara
        Route::get('/jadwal', [JadwalSementaraController::class, 'index'])->name('jadwal-sementara.index');
        Route::get('/jadwal/create', [JadwalSementaraController::class, 'create'])->name('jadwal-sementara.create');
        Route::post('/jadwal', [JadwalSementaraController::class, 'store'])->name('jadwal-sementara.store');
        Route::get('/jadwal/{jadwalSementara}/edit', [JadwalSementaraController::class, 'edit'])->name('jadwal-sementara.edit');
        Route::put('/jadwal/{jadwalSementara}', [JadwalSementaraController::class, 'update'])->name('jadwal-sementara.update');
        Route::delete('/jadwal/{jadwalSementara}', [JadwalSementaraController::class, 'destroy'])->name('jadwal-sementara.destroy');

        //kelas
        Route::get('/kelas-data', [KelasController::class, 'index'])->name('kelas.index')->middleware(['permission:read_kelas']);
        Route::get('/kelas-data/create', [KelasController::class, 'create'])->name('kelas.create')->middleware(['permission:create_kelas']);
        Route::post('/kelas-data', [KelasController::class, 'store'])->name('kelas.store')->middleware(['permission:create_kelas']);
        Route::get('/kelas-data/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit')->middleware(['permission:update_kelas']);
        Route::put('/kelas-data/{kelas}', [KelasController::class, 'update'])->name('kelas.update')->middleware(['permission:update_kelas']);
        Route::delete('/kelas-data/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy')->middleware(['permission:delete_kelas']);
        Route::get('/kelas-data/{id}/show', [KelasController::class, 'show'])->name('kelas.show')->middleware(['permission:read_kelas']);
        Route::get('/kelas-data/exportEvaluasi', [KelasController::class, 'exportEvaluasi'])->name('kelas.exportEvaluasi');
        //export by id
        Route::get('/kelas-data/export/{id}', [KelasController::class, 'exportDetail'])->name('kelas.exportById');
        //export matakuliah
        Route::get('/kelas-data/exportKelas', [KelasController::class, 'exportKelas'])->name('kelas.exportKelas');
        //export matakuliah
        Route::get('/kelas-data/exportMatakuliah', [KelasController::class, 'exportMatakuliah'])->name('kelas.exportMatakuliah');

        //periode perkuliahan
        Route::get('/periode-perkuliahan', [PeriodePerkuliahanController::class, 'index'])->name('periode-perkuliahan.index');
        Route::get('/periode-perkuliahan/create', [PeriodePerkuliahanController::class, 'create'])->name('periode-perkuliahan.create');
        Route::post('/periode-perkuliahan', [PeriodePerkuliahanController::class, 'store'])->name('periode-perkuliahan.store');
        Route::get('/periode-perkuliahan/{id}/edit', [PeriodePerkuliahanController::class, 'edit'])->name('periode-perkuliahan.edit');
        Route::put('/periode-perkuliahan/{id}', [PeriodePerkuliahanController::class, 'update'])->name('periode-perkuliahan.update');
        Route::delete('/periode-perkuliahan/{id}', [PeriodePerkuliahanController::class, 'destroy'])->name('periode-perkuliahan.destroy');
        Route::get('/periode-perkuliahan/{id}/show', [PeriodePerkuliahanController::class, 'show'])->name('periode-perkuliahan.show');

        // skala-nilai
        Route::get('/skala-nilai', [SkalaNilaiController::class, 'index'])->name('skala-nilai.index');
        Route::get('/skala-nilai/create', [SkalaNilaiController::class, 'create'])->name('skala-nilai.create');
        Route::post('/skala-nilai/store', [SkalaNilaiController::class, 'store'])->name('skala-nilai.store');
        Route::get('/skala-nilai/{skalaNilai}/edit', [SkalaNilaiController::class, 'edit'])->name('skala-nilai.edit');
        Route::put('/skala-nilai/{skalaNilai}', [SkalaNilaiController::class, 'update'])->name('skala-nilai.update');
        Route::delete('/skala-nilai/{skalaNilai}', [SkalaNilaiController::class, 'destroy'])->name('skala-nilai.destroy');
        Route::get('/skala-nilai/{id}/show', [SkalaNilaiController::class, 'show'])->name('skala-nilai.show');

        Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
        Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
        Route::get('/nilai/{nilai}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
        Route::put('/nilai/{nilai}', [NilaiController::class, 'update'])->name('nilai.update');
        Route::delete('/nilai/{nilai}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
        Route::get('/nilai/{id}/show', [NilaiController::class, 'show'])->name('nilai.show');

        Route::get('/nilai/{id}/pdf', [NilaiController::class, 'cetakPdf'])->name('nilai.pdf');
        //export
        Route::get('/nilai/export', [NilaiController::class, 'export'])->name('nilai.export');
        //exportKomponenEvaluasi
        Route::get('/nilai/exportKomponenEvaluasi', [NilaiController::class, 'exportKomponenEvaluasi'])->name('nilai.exportKomponenEvaluasi');
        // nilai import
        Route::post('/nilai/import', [NilaiController::class, 'import'])->name('nilai.import');
        // nilai download template
        Route::get('/nilai/template', [NilaiController::class, 'downloadTemplate'])->name('nilai.template');

        //jadwal-ujian
        Route::get('/jadwal-ujian', [JadwalUjianController::class, 'index'])->name('jadwal-ujian.index');
        Route::get('/jadwal-ujian/create', [JadwalUjianController::class, 'create'])->name('jadwal-ujian.create');
        Route::post('/jadwal-ujian/store', [JadwalUjianController::class, 'store'])->name('jadwal-ujian.store');
        Route::get('/jadwal-ujian/{id}/edit', [JadwalUjianController::class, 'edit'])->name('jadwal-ujian.edit');
        Route::put('/jadwal-ujian/{id}', [JadwalUjianController::class, 'update'])->name('jadwal-ujian.update');
        Route::delete('/jadwal-ujian/{id}', [JadwalUjianController::class, 'destroy'])->name('jadwal-ujian.destroy');
        Route::get('/jadwal-ujian/{id}/show', [JadwalUjianController::class, 'show'])->name('jadwal-ujian.show');
        Route::get('/jadwal-ujian/get-matakuliah/{kelas_id}', [JadwalUjianController::class, 'getMatakuliah']);

        //jadwal

    });

    Route::post('/proxy-update-lms-password', [LoginController::class, 'proxyUpdatePassword']);
    Route::get('/clear-lms-password-session', [LoginController::class, 'clearLmsPasswordSession']);

    // Route::get('/jadwal/details/{paketMataKuliah}', [JadwalController::class, 'getPaketDetails'])->middleware(['permission:read_jadwal']);

    Route::get('/kelas/details/{kurikulum}', [KelasController::class, 'getKurikulumDetails'])->name('kelas.details');

    // Route untuk mengambil mata kuliah berdasarkan program studi dan semester
    Route::get('/kurikulum/get-matakuliah/{prodi}/{semester}', [KurikulumController::class, 'getMataKuliah'])->name('get-matakuliah');
    Route::post('/kurikulum/get-matakuliah-details', [KurikulumController::class, 'getMataKuliahDetails']);

    // Rute untuk AJAX
    Route::get('/nilai/getKelasMataKuliah/{programStudiId}', [NilaiController::class, 'getKelasMataKuliah']);
    // get mahaasiswa
    Route::get('/nilai/get-mahasiswa/{kelasId}', [NilaiController::class, 'getMahasiswaByKelas']);
    // Route untuk mendapatkan data kelas berdasarkan Program Studi
    Route::get('/nilai/getKelas/{programStudiId}', [NilaiController::class, 'getKelasByProgramStudi']);

    // Route untuk mendapatkan data mata kuliah berdasarkan Program Studi
    Route::get('/matakuliah/{kelasId}', [NilaiController::class, 'getMatakuliahByKelas']);


    // prestasi
    Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index')->middleware(['permission:read_prestasi']);
    Route::get('/prestasi/create', [PrestasiController::class, 'create'])->name('prestasi.create')->middleware(['permission:create_prestasi']);
    Route::post('/prestasi', [PrestasiController::class, 'store'])->name('prestasi.store')->middleware(['permission:create_prestasi']);
    Route::get('/prestasi/{prestasi}/edit', [PrestasiController::class, 'edit'])->name('prestasi.edit')->middleware(['permission:update_prestasi']);
    Route::put('/prestasi/{prestasi}', [PrestasiController::class, 'update'])->name('prestasi.update')->middleware(['permission:update_prestasi']);
    Route::delete('/prestasi/{prestasi}', [PrestasiController::class, 'destroy'])->name('prestasi.destroy')->middleware(['permission:delete_prestasi']);
    Route::get('/prestasi/show/{id}', [PrestasiController::class, 'show'])->name('prestasi.show')->middleware(['permission:read_prestasi']);
    Route::get('/getMahasiswaByProdi', [PrestasiController::class, 'getMahasiswaByProdi'])->name('getMahasiswaByProdi');
});

//login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/loginFrom', [LoginController::class, 'generateLoginURL'])->name('login.generateURL');
Route::get('/prosesLogin/{hp}/{otp}', [LoginController::class, 'prosesLogin'])->name('login.processLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/lms', function () {
    return view('feature.feature.lms');
})->name('lms');
// Route::post('/proxy-update-lms-password', [LoginController::class, 'proxyUpdatePassword']);
// Route::get('/clear-lms-password-session', [LoginController::class, 'clearLmsPasswordSession']);
