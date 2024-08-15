<?php

namespace App\Http\Controllers;

use App\Http\Requests\KtpRequest;
use App\Models\Ktp;
use App\Models\Mahasiswa;
use App\Models\MahasiswaDetail;
use App\Models\MahasiswaWali;
use App\Models\MahasiswaWaliDetail;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $mahasiswa = Mahasiswa::when($search, function ($query, $search) {
            $query->where('nim', 'like', "%$search%")
                ->orWhere('nama', 'like', "%$search%");
        })
            ->paginate(10);

        return view('master.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        // Fetch data for the dropdowns
        $provinces = Province::all();
        $prodi = ProgramStudi::all();
        return view('master.mahasiswa.create', compact('provinces', 'prodi'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        // Fetch data for the dropdowns
        $prodi = ProgramStudi::all();

        // Fetch data for the dropdowns and populate with existing data
        $provinces = Province::all();
        $cities = City::where('province_code', $mahasiswa->ktp->alamat_prov_code)->get();
        $districts = District::where('city_code', $mahasiswa->ktp->alamat_kotakab_code)->get();
        $villages = Village::where('district_code', $mahasiswa->ktp->alamat_kec_code)->get();

        return view('master.mahasiswa.edit', compact('mahasiswa', 'prodi', 'provinces', 'cities', 'districts', 'villages'));
    }

    public function storeOrUpdate(Request $request)
    {
        $data = $request->all();

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
                'program_studi_id' => $data['program_studi'],
                'registrasi_tanggal' => $data['registrasi_tanggal'],
                'status' => $data['status'],
                'semester_berjalan' => $data['semester_berjalan'],
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
            MahasiswaDetail::updateOrCreate(
                ['mahasiswa_id' => $mahasiswa->id],
                $newMahasiswaDetail
            );
        }

        // Handle KTP Wali
        $ktpWali = Ktp::updateOrCreate(
            ['nik' => $data['wali_nik']],
            [
                'nama' => $data['wali_nama'],
                'alamat_jalan' => $data['wali_alamat_jalan'],
                'alamat_rt' => $data['wali_alamat_rt'],
                'alamat_rw' => $data['wali_alamat_rw'],
                'alamat_prov_code' => $data['wali_alamat_prov_code'],
                'alamat_kotakab_code' => $data['wali_alamat_kotakab_code'],
                'alamat_kec_code' => $data['wali_alamat_kec_code'],
                'alamat_kel_code' => $data['wali_alamat_kel_code'],
                'lahir_tempat' => $data['wali_lahir_tempat'],
                'lahir_tgl' => $data['wali_lahir_tgl'],
                'jenis_kelamin' => $data['wali_jenis_kelamin'],
                'agama' => $data['wali_agama'],
                'golongan_darah' => $data['wali_golongan_darah'],
                'kewarganegaraan' => $data['wali_kewarganegaraan'],
            ]
        );

        // Handle MahasiswaWali
        $mahasiswaWali = MahasiswaWali::updateOrCreate(
            ['mahasiswa_id' => $mahasiswa->id],
            [
                'ktp_id' => $ktpWali->id,
                'nama' => $data['wali_nama'],
                'status_kewalian' => $data['status_kewalian'],
            ]
        );

        // Handle MahasiswaWaliDetail
        $existingMahasiswaWaliDetail = MahasiswaWaliDetail::where('mahasiswa_wali_id', $mahasiswaWali->id)->first();
        $newMahasiswaWaliDetail = [
            'hp' => $data['wali_no_hp'],
            'alamat_domisili' => $data['wali_alamat_domisili'],
            'pekerjaan' => $data['wali_pekerjaan'],
            'penghasilan' => $data['wali_penghasilan'],
            'pendidikan' => $data['pendidikan_terakhir'],
        ];

        if (!$existingMahasiswaWaliDetail || $existingMahasiswaWaliDetail->hp != $newMahasiswaWaliDetail['hp'] || $existingMahasiswaWaliDetail->alamat_domisili != $newMahasiswaWaliDetail['alamat_domisili']) {
            MahasiswaWaliDetail::updateOrCreate(
                ['mahasiswa_wali_id' => $mahasiswaWali->id],
                $newMahasiswaWaliDetail
            );
        }

        // Set success message based on the request type
        $message = $request->has('id') ? 'Data berhasil diperbarui' : 'Data berhasil ditambahkan';

        // Redirect with success message
        return redirect()->route('mahasiswa.index')->with('success', $message);
    }


    public function show(Mahasiswa $mahasiswa)
    {
        // Mengambil data KTP dari relasi mahasiswa
        $ktp = $mahasiswa->ktp;

        $wali = $mahasiswa->mahasiswaWali;

        // Mendapatkan data provinsi, kota/kabupaten, kecamatan, dan kelurahan/desa dari relasi KTP
        $province = $ktp->province;
        $city = $ktp->city;
        $district = $ktp->district;
        $village = $ktp->village;

        $waliprovince = $wali->ktp->province;
        $walicity = $wali->ktp->city;
        $walidistrict = $wali->ktp->district;
        $walivillage = $wali->ktp->village;

        // Mengirim data ke view
        return view('master.mahasiswa.detail', [
            'mahasiswa' => $mahasiswa, // Jangan lupa untuk mengirim data mahasiswa ke view
            'ktp' => $ktp,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'village' => $village,
            'wali' => $wali,
            'waliprovince' => $waliprovince,
            'walicity' => $walicity,
            'walidistrict' => $walidistrict,
            'walivillage' => $walivillage,
        ]);
    }

    public function destroy(Ktp $ktp)
    {
        $ktp->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'KTP berhasil dihapus');
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
