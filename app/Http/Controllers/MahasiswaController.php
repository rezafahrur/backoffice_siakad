<?php

namespace App\Http\Controllers;

use App\Http\Requests\KtpRequest;
use App\Http\Requests\MahasiswaRequest;
use App\Models\Jurusan;
use App\Models\Ktp;
use App\Models\Mahasiswa;
use App\Models\MahasiswaDetail;
use App\Models\MahasiswaWali;
use App\Models\MahasiswaWaliDetail;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Yajra\DataTables\Facades\DataTables;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mhs = Mahasiswa::query();

            return DataTables::of($mhs)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $showBtn = '<a href="' . route('mahasiswa.show', $row->id) . '" class="btn icon btn-sm btn-info" title="Detail"><i class="bi bi-eye"></i></a>';
                    $editBtn = '<a href="' . route('mahasiswa.edit', $row->id) . '" class="btn icon btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<form action="' . route('mahasiswa.destroy', $row->id) . '" method="post" class="d-inline">
                                      ' . csrf_field() . method_field('DELETE') . '
                                      <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-sm btn-danger" title="Delete">
                                          <i class="bi bi-trash"></i>
                                      </button>
                                  </form>';
                    return $showBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action']) // Ensures that HTML code for the action buttons is rendered correctly
                ->make(true);
        }
        return view('master.mahasiswa.index');
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

        // Fetch data wali by mahasiswa ID
        $wali1 = MahasiswaWali::where('mahasiswa_id', $id)
            ->where('status_kewalian', 'AYAH')
            ->first();

        $wali2 = MahasiswaWali::where('mahasiswa_id', $id)
            ->where('status_kewalian', 'IBU')
            ->first();

        // dd($wali1->mahasiswaWaliDetail->hp, $wali2->mahasiswaWaliDetail->hp, $mahasiswa->mahasiswaDetail->hp);

        // Fetch data for the dropdowns and populate with existing data
        $provinces = Province::all();

        return view('master.mahasiswa.edit', compact('mahasiswa', 'prodi', 'provinces', 'wali1', 'wali2', 'jurusan'));
    }

    public function storeOrUpdate(MahasiswaRequest $request)
    {
        $data = $request->validated();

        // Validate nim apakah create atau update ( jika ada id berarti update )
        if (!$request->has('id')) {
            // Extract values and prepare NIM
            $year = substr($data['registrasi_tanggal'], 2, 2);
            $jenjang = '04';

            $jurusan = Jurusan::find($data['program_studi']);
            $jrs = str_pad($jurusan->kode_jurusan, 2, '0', STR_PAD_LEFT);

            $programStudi = ProgramStudi::find($data['program_studi']);
            $program = str_pad($programStudi->kode_program_studi, 2, '0', STR_PAD_LEFT);

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
                        'nama_kontak_darurat' => $data['kd_nama'],
                        'hubungan_kontak_darurat' => $data['kd_hubungan'],
                        'hp_kontak_darurat' => $data['kd_no_hp'],
                        'ktp_id' => $ktpMahasiswa->id,
                    ]
                );

                // Handle MahasiswaDetail
                $existingMahasiswaDetail = MahasiswaDetail::where('mahasiswa_id', $mahasiswa->id)->first();
                $newMahasiswaDetail = [
                    'hp' => $data['no_hp'],
                    'alamat_domisili' => $data['alamat_domisili'],
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

                if ($existingMahasiswaWaliDetail1->hp != $newMahasiswaWaliDetail1['hp'] || $existingMahasiswaWaliDetail1->alamat_domisili != $newMahasiswaWaliDetail1['alamat_domisili']) {
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

                if ($existingMahasiswaWaliDetail2->hp != $newMahasiswaWaliDetail2['hp'] || $existingMahasiswaWaliDetail2->alamat_domisili != $newMahasiswaWaliDetail2['alamat_domisili']) {
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
            dd($message . $e->getMessage());
            return redirect()->back()->with('error', $message . $e->getMessage());
        }
    }

    public function show(Mahasiswa $mahasiswa)
    {
        // Mengambil data KTP dari relasi mahasiswa
        $ktp = $mahasiswa->ktp;
        $waliCollection = $mahasiswa->id;

        // Contoh mengambil wali pertama, jika ada
        $wali1 = MahasiswaWali::where('mahasiswa_id', $waliCollection)
            ->where('status_kewalian', 'AYAH')
            ->first();

        $wali2 = MahasiswaWali::where('mahasiswa_id', $waliCollection)
            ->where('status_kewalian', 'IBU')
            ->first();

        // Mendapatkan data provinsi, kota/kabupaten, kecamatan, dan kelurahan/desa dari relasi KTP
        $province = $ktp->province;
        $city = $ktp->city;
        $district = $ktp->district;
        $village = $ktp->village;

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
        ]);
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
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
            exit;
        }

        // Hapus KTP mahasiswa jika ada
        if ($mahasiswa->ktp) {
            $mahasiswa->ktp->delete();
        }

        // Hapus Mahasiswa
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa dan data terkait berhasil dihapus');
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
