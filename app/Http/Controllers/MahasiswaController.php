<?php

namespace App\Http\Controllers;

use App\Exports\MahasiswaExport;
use App\Http\Requests\KtpRequest;
use App\Http\Requests\MahasiswaRequest;
use App\Imports\MahasiswaImport;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Krs;
use App\Models\Ktp;
use App\Models\Kurikulum;
use App\Models\KurikulumDetail;
use App\Models\Mahasiswa;
use App\Models\MahasiswaDetail;
use App\Models\MahasiswaWali;
use App\Models\MahasiswaWaliDetail;
use App\Models\mataKuliah;
use App\Models\PaketMataKuliah;
use App\Models\PaketMataKuliahDetail;
use App\Models\ProgramStudi;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::all();
        $prodi = ProgramStudi::all();
        $jurusan = Jurusan::all();

        return view('master.mahasiswa.index', compact('mahasiswa', 'prodi', 'jurusan'));
    }

    public function export(Request $request)
    {
        $dataLengkap = $request->input('dataLengkap', 0);

        if ($dataLengkap) {
            return Excel::download(new MahasiswaExport($dataLengkap), 'mahasiswa.xlsx');
        } else {
            return Excel::download(new MahasiswaExport($dataLengkap), 'mahasiswa_cepat.xlsx');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new MahasiswaImport, $request->file('file'));

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diimpor.');
    }

    public function quickAddImport(array $data)
    {
        // Proses validasi tetap ada di sini
        $validator = validator($data, [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:m_mahasiswa,email',
            'jurusan' => 'required|exists:m_jurusan,id',
            'program_studi' => 'required|exists:m_program_studi,id',
            'registrasi_tanggal' => 'required|date',
            'semester_berjalan' => 'required|integer',
            'status' => 'required|integer',
            'is_filled' => 'required|integer',
            'telp_rumah' => 'required|string|max:15',
            'no_hp' => 'required|string|max:15',
            'alamat_domisili' => 'required|string',
            'kode_pos' => 'required|string|max:6',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        // Logika pembuatan NIM tetap sama
        $year = substr($data['registrasi_tanggal'], 2, 2);
        $jenjang = '04';

        $jurusan = Jurusan::find($data['jurusan']);
        $jrs = str_pad($jurusan->kode_jurusan, 2, '0', STR_PAD_LEFT);

        $programStudi = ProgramStudi::find($data['program_studi']);
        $program = str_pad($programStudi->kode_prodi, 2, '0', STR_PAD_LEFT);

        $lastStudent = Mahasiswa::where('nim', 'like', $year . $jenjang . $jrs . $program . '%')
            ->orderBy('nim', 'desc')
            ->first();

        $newSequence = $lastStudent ? str_pad((int) substr($lastStudent->nim, -4) + 1, 4, '0', STR_PAD_LEFT) : '0001';

        $data['nim'] = $year . $jenjang . $jrs . $program . $newSequence;

        try {
            // Simpan data mahasiswa
            $mahasiswa = Mahasiswa::create([
                'nim' => $data['nim'],
                'nama' => $data['nama'],
                'email' => $data['email'],
                'jurusan_id' => $data['jurusan'],
                'program_studi_id' => $data['program_studi'],
                'registrasi_tanggal' => $data['registrasi_tanggal'],
                'is_filled' => $data['is_filled'],
                'semester_berjalan' => $data['semester_berjalan'],
                'status' => $data['status'],
            ]);

            // Simpan data mahasiswa detail
            MahasiswaDetail::create([
                'telp_rumah' => $data['telp_rumah'],
                'hp' => $data['no_hp'],
                'alamat_domisili' => $data['alamat_domisili'],
                'kode_pos' => $data['kode_pos'],
                'mahasiswa_id' => $mahasiswa->id,
            ]);

            // Kembalikan instance model mahasiswa
            return $mahasiswa;
        } catch (\Exception $e) {
            // Jika ada kesalahan, kembalikan exception agar mudah di-handle di Import
            throw new \Exception($e->getMessage());
        }
    }


    public function quickAdd(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:m_mahasiswa,email',
            'jurusan' => 'required|exists:m_jurusan,id',
            'program_studi' => 'required|exists:m_program_studi,id',
            'registrasi_tanggal' => 'required|date',
            'semester_berjalan' => 'required|integer',
            'status' => 'required|integer',
            'is_filled' => 'required|integer',

            // MahasiswaDetail
            'telp_rumah' => 'required|string|max:15',
            'no_hp' => 'required|string|max:15',
            'alamat_domisili' => 'required|string',
            'kode_pos' => 'required|string|max:6',
        ]);

        // Extract values and prepare NIM
        $year = substr($data['registrasi_tanggal'], 2, 2);
        $jenjang = '04';

        $jurusan = Jurusan::find($data['jurusan']);
        $jrs = str_pad($jurusan->kode_jurusan, 2, '0', STR_PAD_LEFT);

        $programStudi = ProgramStudi::find($data['program_studi']);
        $program = str_pad($programStudi->kode_prodi, 2, '0', STR_PAD_LEFT);

        $lastStudent = Mahasiswa::where('nim', 'like', $year . $jenjang . $jrs . $program . '%')
            ->orderBy('nim', 'desc')
            ->first();

        if ($lastStudent) {
            $lastSequence = (int) substr($lastStudent->nim, -4);
            $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '0001';
        }

        $data['nim'] = $year . $jenjang . $jrs . $program . $newSequence;

        try {
            // Simpan data mahasiswa
            $mahasiswa = Mahasiswa::create([
                'nim' => $data['nim'],
                'nama' => $data['nama'],
                'email' => $data['email'],
                'jurusan_id' => $data['jurusan'],
                'program_studi_id' => $data['program_studi'],
                'registrasi_tanggal' => $data['registrasi_tanggal'],
                'is_filled' => $data['is_filled'],
                'semester_berjalan' => $data['semester_berjalan'],
                'status' => $data['status'],
            ]);

            // Simpan data mahasiswa detail
            MahasiswaDetail::create([
                'telp_rumah' => $data['telp_rumah'],
                'hp' => $data['no_hp'],
                'alamat_domisili' => $data['alamat_domisili'],
                'kode_pos' => $data['kode_pos'],
                'mahasiswa_id' => $mahasiswa->id,
            ]);

            // Redirect with success message
            $message = $request->has('id') ? 'Data berhasil diperbarui' : 'Data berhasil ditambahkan';
            return redirect()->route('mahasiswa.index')->with('success', $message);
        } catch (\Exception $e) {
            // Handle the exception and redirect back with the error message
            $message = isset($request) && $request->has('id') ? 'Data gagal diperbarui' : 'Data gagal ditambahkan';
            return redirect()->back()->withInput()->with([
                'error' => $e->getMessage(),
                'toast_message' => $message,
            ]);
        }
    }

    public function bayar(Request $request)
    {
        $validatedData = $request->validate([
            'mahasiswa_id' => 'required|exists:m_mahasiswa,id',
            'status' => 'required|integer|max:2',
            'tgl_transfer' => 'required|date',
            'kurikulum_id' => 'required|exists:m_kurikulum,id',
            'kelas_id' => 'required|exists:m_kelas,id',
        ]);

        // Proses pembayaran di sini, misalnya menyimpan data ke database
        Krs::create($validatedData);

        // Update status di tabel mahasiswa
        Mahasiswa::find($validatedData['mahasiswa_id'])->update(['status' => $validatedData['status']]);

        return redirect()->route('mahasiswa.index')->with('success', 'Pembayaran berhasil diproses.');
    }

    public function getKurikulumDetails($id)
    {
        // Ambil semua KurikulumDetail yang berhubungan dengan kurikulum_id
        $kurikulumDetails = KurikulumDetail::where('kurikulum_id', $id)->get();

        // Cek jika ada data yang ditemukan
        if ($kurikulumDetails->isNotEmpty()) {
            $matakuliahDetails = [];
            $kelasDetails = [];

            // Iterasi setiap kurikulum detail dan ambil nama mata kuliah dari tabel Matakuliah
            foreach ($kurikulumDetails as $detail) {
                $matakuliah = MataKuliah::find($detail->matakuliah_id);

                // Pastikan data matakuliah ditemukan
                if ($matakuliah) {
                    $matakuliahDetails[] = [
                        'nama_matakuliah' => $matakuliah->nama_matakuliah,
                    ];
                }
            }

            // Ambil daftar kelas yang terkait dengan kurikulum_id
            $kelasList = Kelas::where('kurikulum_id', $id)->get();

            // Iterasi setiap kelas dan cek apakah kapasitasnya sudah penuh
            foreach ($kelasList as $kelas) {
                // Hitung jumlah mahasiswa di kelas ini
                $jumlahMahasiswa = Krs::where('kelas_id', $kelas->id)->count();

                // Cek apakah jumlah mahasiswa kurang dari kapasitas kelas
                if ($jumlahMahasiswa < $kelas->kapasitas) {
                    $kelasDetails[] = [
                        'id' => $kelas->id,
                        'nama_kelas' => $kelas->nama_kelas,
                        'kapasitas' => $kelas->kapasitas,
                        'jumlah_mahasiswa' => $jumlahMahasiswa // Hitungan dari query
                    ];
                }
            }

            // Mengembalikan data dalam format JSON
            return response()->json([
                'kurikulum' => $kurikulumDetails->first()->kurikulum->nama_kurikulum, // Nama kurikulum diambil dari relasi
                'matakuliah_details' => $matakuliahDetails,
                'kelas_details' => $kelasDetails
            ]);
        }

        // Mengembalikan error 404 jika kurikulum tidak ditemukan
        return response()->json(null, 404);
    }

    public function getKurikulumBySemester(Request $request)
    {
        $semester = $request->input('semester');
        $prodiId = $request->input('prodi_id');

        // Fetch paket mata kuliah with matching semester and prodi_id
        $kurikulum = Kurikulum::where('semester_angka', $semester)
            ->where('program_studi_id', $prodiId)
            ->where('status', 1) // Optional: Ensure only active packages are shown
            ->get();

        // Return the data as JSON
        return response()->json($kurikulum);
    }

    public function create()
    {
        // Fetch data for the dropdowns
        $provinces = Province::all();
        $prodi = ProgramStudi::all();
        $jurusan = Jurusan::all();

        return view('master.mahasiswa.create', compact('provinces', 'prodi', 'jurusan'));
    }

    public function edit($id)
    {
        // Fetch data for the dropdowns
        $prodi = ProgramStudi::all();
        $jurusan = Jurusan::all();

        // Fetch data mahasiswa by ID
        $mahasiswa = Mahasiswa::findOrFail($id);

        // Check if is_filled is 0
        if ($mahasiswa->is_filled == 0) {
            $provinces = Province::all();
            $mhsDetail = MahasiswaDetail::where('mahasiswa_id', $id)->latest()->first();
            return view('master.mahasiswa.editShort', compact('mahasiswa', 'prodi', 'jurusan', 'mhsDetail', 'provinces'));
        }

        // Fetch data wali by mahasiswa ID
        $wali1 = MahasiswaWali::where('mahasiswa_id', $id)
            ->where('status_kewalian', 'AYAH')
            ->first();

        $wali2 = MahasiswaWali::where('mahasiswa_id', $id)
            ->where('status_kewalian', 'IBU')
            ->first();

        // Fetch data latest mahasiswa detail by mahasiswa ID
        $mhsDetail = MahasiswaDetail::where('mahasiswa_id', $id)->latest()->first();
        $wali1Detail = MahasiswaWaliDetail::where('mahasiswa_wali_id', $wali1->id)->latest()->first();
        $wali2Detail = MahasiswaWaliDetail::where('mahasiswa_wali_id', $wali2->id)->latest()->first();

        // Ambil kebutuhan khusus dari mahasiswa
        $mahasiswaKebutuhanKhusus = is_array($mahasiswa->kebutuhan_khusus) ? $mahasiswa->kebutuhan_khusus : explode(',', $mahasiswa->kebutuhan_khusus);

        // Ambil kebutuhan khusus dari wali (Ayah)
        $wali1KebutuhanKhusus = $wali1 && $wali1->kebutuhan_khusus ? (is_array($wali1->kebutuhan_khusus) ? $wali1->kebutuhan_khusus : explode(',', $wali1->kebutuhan_khusus)) : [];

        // Ambil kebutuhan khusus dari wali (Ibu)
        $wali2KebutuhanKhusus = $wali2 && $wali2->kebutuhan_khusus ? (is_array($wali2->kebutuhan_khusus) ? $wali2->kebutuhan_khusus : explode(',', $wali2->kebutuhan_khusus)) : [];

        // Fetch data for the dropdowns and populate with existing data
        $provinces = Province::all();

        return view('master.mahasiswa.edit', compact('mahasiswa', 'prodi', 'provinces', 'wali1', 'wali2', 'jurusan', 'mhsDetail', 'wali1Detail', 'wali2Detail', 'mahasiswaKebutuhanKhusus', 'wali1KebutuhanKhusus', 'wali2KebutuhanKhusus'));
    }

    public function storeOrUpdate(MahasiswaRequest $request)
    {
        $data = $request->validated();

        // Validate nim apakah create atau update ( jika ada id berarti update )
        if (!$request->has('id')) {
            // Extract values and prepare NIM
            $year = substr($data['registrasi_tanggal'], 2, 2);
            $jenjang = '04';

            $jurusan = Jurusan::find($data['jurusan']);
            $jrs = str_pad($jurusan->kode_jurusan, 2, '0', STR_PAD_LEFT);

            $programStudi = ProgramStudi::find($data['program_studi']);
            $program = str_pad($programStudi->kode_prodi, 2, '0', STR_PAD_LEFT);

            $lastStudent = Mahasiswa::where('nim', 'like', $year . $jenjang . $jrs . $program . '%')
                ->orderBy('nim', 'desc')
                ->first();

            if ($lastStudent) {
                $lastSequence = (int) substr($lastStudent->nim, -4);
                $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newSequence = '0001';
            }

            $data['nim'] = $year . $jenjang . $jrs . $program . $newSequence;
        } else {
            $data['nim'] = Mahasiswa::find($request['id'])->nim;
        }

        try {
            DB::transaction(function () use ($data) {
                // Handle KTP Mahasiswa
                $ktpMahasiswa = Ktp::updateOrCreate(
                    ['nik' => $data['nik']],
                    [
                        'nama' => $data['nama'],
                        'alamat_jalan' => $data['alamat_jalan'],
                        'alamat_rt' => $data['alamat_rt'],
                        'alamat_rw' => $data['alamat_rw'],
                        'alamat_prov_code' => $data['alamat_prov_code'],
                        'alamat_kotakab_code' => $data['alamat_kotakab_code'],
                        'alamat_kec_code' => $data['alamat_kec_code'],
                        'alamat_kel_code' => $data['alamat_kel_code'],
                        'lahir_tempat' => $data['lahir_tempat'],
                        'lahir_tgl' => $data['lahir_tgl'],
                        'jenis_kelamin' => $data['jenis_kelamin'],
                        'agama' => $data['agama'],
                        'golongan_darah' => $data['golongan_darah'],
                        'kewarganegaraan' => $data['kewarganegaraan'],
                    ]
                );

                // Handle Mahasiswa
                $mahasiswa = Mahasiswa::updateOrCreate(
                    ['nim' => $data['nim']],
                    [
                        'nama' => $data['nama'],
                        'nisn' => $data['nisn'],
                        'email' => $data['email'],
                        'jurusan_id' => $data['jurusan'],
                        'program_studi_id' => $data['program_studi'],
                        'registrasi_tanggal' => $data['registrasi_tanggal'],
                        'status' => $data['status'],
                        'semester_berjalan' => $data['semester_berjalan'],
                        'npwp' => $data['npwp'],
                        'jenis_tinggal' => $data['jenis_tinggal'],
                        'alat_transportasi' => $data['alat_transportasi'],
                        'terima_kps' => $data['terima_kps'],
                        'no_kps' => $data['no_kps'],
                        'kebutuhan_khusus' => isset($data['kebutuhan_khusus_mahasiswa']) ? implode(',', $data['kebutuhan_khusus_mahasiswa']) : '0',
                        'nama_kontak_darurat' => $data['kd_nama'],
                        'hubungan_kontak_darurat' => $data['kd_hubungan'],
                        'hp_kontak_darurat' => $data['kd_no_hp'],
                        'tgl_lahir_kontak_darurat' => $data['kd_tgl_lahir'],
                        'pekerjaan_kontak_darurat' => $data['kd_pekerjaan'],
                        'pendidikan_kontak_darurat' => $data['kd_pendidikan'],
                        'penghasilan_kontak_darurat' => $data['kd_penghasilan'],
                        'is_filled' => $data['is_filled'],
                        'ktp_id' => $ktpMahasiswa->id,
                    ]
                );

                // Handle MahasiswaDetail
                $existingMahasiswaDetail = MahasiswaDetail::where('mahasiswa_id', $mahasiswa->id)->first();
                $newMahasiswaDetail = [
                    'hp' => $data['no_hp'],
                    'alamat_domisili' => $data['alamat_domisili'],
                    'telp_rumah' => $data['telp_rumah'],
                    'kode_pos' => $data['kode_pos'],
                ];

                if (!$existingMahasiswaDetail || $existingMahasiswaDetail->hp != $newMahasiswaDetail['hp'] || $existingMahasiswaDetail->alamat_domisili != $newMahasiswaDetail['alamat_domisili']) {
                    MahasiswaDetail::create(
                        ['mahasiswa_id' => $mahasiswa->id] + $newMahasiswaDetail
                    );
                }

                // Handle KTP Wali 1
                $ktpWali1 = Ktp::updateOrCreate(
                    ['nik' => $data['wali_nik_1']],
                    [
                        'nama' => $data['wali_nama_1'],
                        'alamat_jalan' => $data['wali_alamat_jalan_1'],
                        'alamat_rt' => $data['wali_alamat_rt_1'],
                        'alamat_rw' => $data['wali_alamat_rw_1'],
                        'alamat_prov_code' => $data['wali_alamat_prov_code_1'],
                        'alamat_kotakab_code' => $data['wali_alamat_kotakab_code_1'],
                        'alamat_kec_code' => $data['wali_alamat_kec_code_1'],
                        'alamat_kel_code' => $data['wali_alamat_kel_code_1'],
                        'lahir_tempat' => $data['wali_lahir_tempat_1'],
                        'lahir_tgl' => $data['wali_lahir_tgl_1'],
                        'jenis_kelamin' => $data['wali_jenis_kelamin_1'],
                        'agama' => $data['wali_agama_1'],
                        'golongan_darah' => $data['wali_golongan_darah_1'],
                        'kewarganegaraan' => $data['wali_kewarganegaraan_1'],
                    ]
                );

                // Handle MahasiswaWali 1
                $mahasiswaWali1 = MahasiswaWali::updateOrCreate(
                    [
                        'mahasiswa_id' => $mahasiswa->id,
                        'ktp_id' => $ktpWali1->id,
                    ],
                    [
                        'nama' => $data['wali_nama_1'],
                        'status_kewalian' => 'AYAH',
                        'kebutuhan_khusus' => isset($data['kebutuhan_khusus_ayah']) ? implode(',', $data['kebutuhan_khusus_ayah']) : '0',
                    ]
                );

                // Handle MahasiswaWaliDetail 1
                $existingMahasiswaWaliDetail1 = MahasiswaWaliDetail::where('mahasiswa_wali_id', $mahasiswaWali1->id)->first();
                $newMahasiswaWaliDetail1 = [
                    'hp' => $data['wali_no_hp_1'],
                    'alamat_domisili' => $data['wali_alamat_domisili_1'],
                    'pekerjaan' => $data['wali_pekerjaan_1'],
                    'penghasilan' => $data['wali_penghasilan_1'],
                    'pendidikan' => $data['pendidikan_terakhir_1'],
                ];

                if (!$existingMahasiswaWaliDetail1 || $existingMahasiswaWaliDetail1->hp != $newMahasiswaWaliDetail1['hp'] || $existingMahasiswaWaliDetail1->alamat_domisili != $newMahasiswaWaliDetail1['alamat_domisili']) {
                    MahasiswaWaliDetail::create(
                        ['mahasiswa_wali_id' => $mahasiswaWali1->id] + $newMahasiswaWaliDetail1
                    );
                } else {
                    $existingMahasiswaWaliDetail1->update($newMahasiswaWaliDetail1);
                }

                // Handle KTP Wali 2
                $ktpWali2 = Ktp::updateOrCreate(
                    ['nik' => $data['wali_nik_2']],
                    [
                        'nama' => $data['wali_nama_2'],
                        'alamat_jalan' => $data['wali_alamat_jalan_2'],
                        'alamat_rt' => $data['wali_alamat_rt_2'],
                        'alamat_rw' => $data['wali_alamat_rw_2'],
                        'alamat_prov_code' => $data['wali_alamat_prov_code_2'],
                        'alamat_kotakab_code' => $data['wali_alamat_kotakab_code_2'],
                        'alamat_kec_code' => $data['wali_alamat_kec_code_2'],
                        'alamat_kel_code' => $data['wali_alamat_kel_code_2'],
                        'lahir_tempat' => $data['wali_lahir_tempat_2'],
                        'lahir_tgl' => $data['wali_lahir_tgl_2'],
                        'jenis_kelamin' => $data['wali_jenis_kelamin_2'],
                        'agama' => $data['wali_agama_2'],
                        'golongan_darah' => $data['wali_golongan_darah_2'],
                        'kewarganegaraan' => $data['wali_kewarganegaraan_2'],
                    ]
                );

                // Handle MahasiswaWali
                $mahasiswaWali2 = MahasiswaWali::updateOrCreate(
                    [
                        'mahasiswa_id' => $mahasiswa->id,
                        'ktp_id' => $ktpWali2->id
                    ],
                    [
                        'nama' => $data['wali_nama_2'],
                        'status_kewalian' => 'IBU',
                        'kebutuhan_khusus' => isset($data['kebutuhan_khusus_ibu']) ? implode(',', $data['kebutuhan_khusus_ibu']) : '0',
                    ]
                );

                // Handle MahasiswaWaliDetail
                $existingMahasiswaWaliDetail2 = MahasiswaWaliDetail::where('mahasiswa_wali_id', $mahasiswaWali2->id)->first();
                $newMahasiswaWaliDetail2 = [
                    'hp' => $data['wali_no_hp_2'],
                    'alamat_domisili' => $data['wali_alamat_domisili_2'],
                    'pekerjaan' => $data['wali_pekerjaan_2'],
                    'penghasilan' => $data['wali_penghasilan_2'],
                    'pendidikan' => $data['pendidikan_terakhir_2'],
                ];

                if (!$existingMahasiswaWaliDetail2 || $existingMahasiswaWaliDetail2->hp != $newMahasiswaWaliDetail2['hp'] || $existingMahasiswaWaliDetail2->alamat_domisili != $newMahasiswaWaliDetail2['alamat_domisili']) {
                    MahasiswaWaliDetail::create(
                        ['mahasiswa_wali_id' => $mahasiswaWali2->id] + $newMahasiswaWaliDetail2
                    );
                } else {
                    $existingMahasiswaWaliDetail2->update($newMahasiswaWaliDetail2);
                }
            });

            // Redirect with success message
            $message = $request->has('id') ? 'Data berhasil diperbarui' : 'Data berhasil ditambahkan';
            return redirect()->route('mahasiswa.index')->with('success', $message);
        } catch (\Exception $e) {
            // Handle the exception and redirect back with the error message
            $message = isset($request) && $request->has('id') ? 'Data gagal diperbarui' : 'Data gagal ditambahkan';
            return redirect()->back()->withInput()->with([
                'error' => $e->getMessage(),
                'toast_message' => $message,
            ]);
        }
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $waliCollection = $mahasiswa->id;
        $krs = Krs::where('mahasiswa_id', $waliCollection)->get();

        if ($mahasiswa->is_filled == 0) {
            $mhsDetail = MahasiswaDetail::where('mahasiswa_id', $waliCollection)->latest()->get();

            return view('master.mahasiswa.detailShort', [
                'mahasiswa' => $mahasiswa,
                'mhsDetail' => $mhsDetail,
                'krs' => $krs,
            ]);
        }

        // Mengambil data KTP dari relasi mahasiswa
        $ktp = $mahasiswa->ktp;

        // Mengambil detail mahasiswa jika ada
        $mhsDetail = MahasiswaDetail::where('mahasiswa_id', $waliCollection)->latest()->get();

        // Contoh mengambil wali pertama, jika ada
        $wali1 = MahasiswaWali::where('mahasiswa_id', $waliCollection)
            ->where('status_kewalian', 'AYAH')
            ->first();

        $wali2 = MahasiswaWali::where('mahasiswa_id', $waliCollection)
            ->where('status_kewalian', 'IBU')
            ->first();

        // mengambil detail wali jika ada
        $wali1Detail = MahasiswaWaliDetail::where('mahasiswa_wali_id', $wali1->id)->latest()->get();
        $wali2Detail = MahasiswaWaliDetail::where('mahasiswa_wali_id', $wali2->id)->latest()->get();

        // Mendapatkan data provinsi, kota/kabupaten, kecamatan, dan kelurahan/desa dari relasi KTP
        $province = $ktp->province;
        $city = $ktp->city;
        $district = $ktp->district;
        $village = $ktp->village;

        // Ambil kebutuhan khusus dari mahasiswa
        $mahasiswaKebutuhanKhusus = is_array($mahasiswa->kebutuhan_khusus) ? $mahasiswa->kebutuhan_khusus : explode(',', $mahasiswa->kebutuhan_khusus);

        // Ambil kebutuhan khusus dari wali (Ayah)
        $wali1KebutuhanKhusus = $wali1 && $wali1->kebutuhan_khusus ? (is_array($wali1->kebutuhan_khusus) ? $wali1->kebutuhan_khusus : explode(',', $wali1->kebutuhan_khusus)) : [];

        // Ambil kebutuhan khusus dari wali (Ibu)
        $wali2KebutuhanKhusus = $wali2 && $wali2->kebutuhan_khusus ? (is_array($wali2->kebutuhan_khusus) ? $wali2->kebutuhan_khusus : explode(',', $wali2->kebutuhan_khusus)) : [];

        if ($wali1) {
            $wali1province = $wali1->ktp->province;
            $wali1city = $wali1->ktp->city;
            $wali1district = $wali1->ktp->district;
            $wali1village = $wali1->ktp->village;
        }

        if ($wali2) {
            $wali2province = $wali2->ktp->province;
            $wali2city = $wali2->ktp->city;
            $wali2district = $wali2->ktp->district;
            $wali2village = $wali2->ktp->village;
        }

        // Mengirim data ke view
        return view('master.mahasiswa.detail', [
            'mahasiswa' => $mahasiswa,
            'ktp' => $ktp,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'village' => $village,
            'wali1' => $wali1 ?? null,
            'wali1province' => $wali1province ?? null,
            'wali1city' => $wali1city ?? null,
            'wali1district' => $wali1district ?? null,
            'wali1village' => $wali1village ?? null,
            'wali2' => $wali2 ?? null,
            'wali2province' => $wali2province ?? null,
            'wali2city' => $wali2city ?? null,
            'wali2district' => $wali2district ?? null,
            'wali2village' => $wali2village ?? null,
            'wali1Detail' => $wali1Detail ?? null,
            'wali2Detail' => $wali2Detail ?? null,
            'mhsDetail' => $mhsDetail ?? null,
            'krs' => $krs ?? null,
            'mahasiswaKebutuhanKhusus' => $mahasiswaKebutuhanKhusus,
            'wali1KebutuhanKhusus' => $wali1KebutuhanKhusus,
            'wali2KebutuhanKhusus' => $wali2KebutuhanKhusus,
        ]);
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        try {
            // Loop through each guardian (Wali)
            foreach ($mahasiswa->mahasiswaWali as $wali) {
                // Simpan referensi ke KTP wali sebelum menghapus MahasiswaWali
                $ktpWali = $wali->ktp;

                // Hapus MahasiswaWaliDetail jika ada
                if ($wali->mahasiswaWaliDetailDelete) {
                    foreach ($wali->mahasiswaWaliDetailDelete as $detail) {
                        $detail->delete();
                    }
                }

                // Hapus KTP wali jika ada
                if ($ktpWali) {
                    $ktpWali->delete();
                }

                // Hapus MahasiswaWali
                $wali->delete();
            }

            // Hapus MahasiswaDetail jika ada
            if ($mahasiswa->mahasiswaDetailDelete) {
                foreach ($mahasiswa->mahasiswaDetailDelete as $detail) {
                    $detail->delete();
                }
            }

            // Hapus KTP mahasiswa jika ada
            if ($mahasiswa->ktp) {
                $mahasiswa->ktp->delete();
            }

            // hapus KRS jika ada
            if ($mahasiswa->krs) {
                foreach ($mahasiswa->krs as $krs) {
                    $krs->delete();
                }
            }

            // Hapus Mahasiswa
            $mahasiswa->delete();

            return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            // Handle the exception and redirect back with the error message
            return redirect()->back()->withInput()->with([
                'error' => $e->getMessage(),
                'toast_message' => 'Data gagal dihapus',
            ]);
        }
    }

    // AJAX handlers for fetching cities, districts, and villages dynamically
    public function getCities($provinceCode)
    {
        $cities = City::where('province_code', $provinceCode)->get();
        return response()->json($cities);
    }

    public function getDistricts($cityCode)
    {
        $districts = District::where('city_code', $cityCode)->get();
        return response()->json($districts);
    }

    public function getVillages($districtCode)
    {
        $villages = Village::where('district_code', $districtCode)->get();
        return response()->json($villages);
    }
}
