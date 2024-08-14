<?php

namespace App\Http\Controllers;

use App\Http\Requests\KtpRequest;
use App\Models\Ktp;
use App\Models\Mahasiswa;
use App\Models\MahasiswaDetail;
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

    public function store(Request $mahasiswaRequest)
    {

        // Create a new KTP record with insertGetId
        $ktp = Ktp::updateOrCreate([
            'nik' => $mahasiswaRequest['nik']
        ], [
            'nama' => $mahasiswaRequest['nama'],
            'alamat_jalan' => $mahasiswaRequest['alamat_jalan'],
            'alamat_rt' => $mahasiswaRequest['alamat_rt'],
            'alamat_rw' => $mahasiswaRequest['alamat_rw'],
            'alamat_prov_code' => $mahasiswaRequest['alamat_prov_code'],
            'alamat_kotakab_code' => $mahasiswaRequest['alamat_kotakab_code'],
            'alamat_kec_code' => $mahasiswaRequest['alamat_kec_code'],
            'alamat_kel_code' => $mahasiswaRequest['alamat_kel_code'],
            'lahir_tempat' => $mahasiswaRequest['lahir_tempat'],
            'lahir_tgl' => $mahasiswaRequest['lahir_tgl'],
            'jenis_kelamin' => $mahasiswaRequest['jenis_kelamin'],
            'agama' => $mahasiswaRequest['agama'],
            'golongan_darah' => $mahasiswaRequest['golongan_darah'],
            'kewarganegaraan' => $mahasiswaRequest['kewarganegaraan'],
        ]);

        // Create a new Mahasiswa record with the KTP ID
        $mahasiswa = Mahasiswa::updateOrCreate([
            'nim' => $mahasiswaRequest['nim'],
        ], [
            'nama' => $mahasiswaRequest['nama'],
            'program_studi_id' => $mahasiswaRequest['program_studi'],
            'registrasi_tanggal' => $mahasiswaRequest['registrasi_tanggal'],
            'status' => $mahasiswaRequest['status'],
            'semester_berjalan' => $mahasiswaRequest['semester_berjalan'],
            'ktp_id' => $ktp->id,
        ]);

        // Create a new MahasiswaDetail record with the Mahasiswa ID
        MahasiswaDetail::create([
            'mahasiswa_id' => $mahasiswa->id,
            'hp' => $mahasiswaRequest['no_hp'],
            'alamat_domisili' => $mahasiswaRequest['alamat_domisili'],
        ]);

        // Redirect to the appropriate route with a success message
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        // Mengambil data KTP dari relasi mahasiswa
        $ktp = $mahasiswa->ktp;

        // Mendapatkan data provinsi, kota/kabupaten, kecamatan, dan kelurahan/desa dari relasi KTP
        $province = $ktp->province;
        $city = $ktp->city;
        $district = $ktp->district;
        $village = $ktp->village;

        // Mengirim data ke view
        return view('master.mahasiswa.detail', [
            'mahasiswa' => $mahasiswa, // Jangan lupa untuk mengirim data mahasiswa ke view
            'ktp' => $ktp,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'village' => $village,
        ]);
    }

    // public function show($id)
    // {
    //     $provinces = Province::all();
    //     $mahasiswa = Mahasiswa::join('m_program_studi', 'm_program_studi.id', '=', 'm_mahasiswa.program_studi_id')->select('m_mahasiswa.*', 'm_program_studi.nama_program_studi')->find($id);
    //     dd($mahasiswa);
    //     return view('master.mahasiswa.detail', compact('mahasiswa', 'provinces'));
    // }

    public function edit(Mahasiswa $mahasiswa)
    {
        // Fetch data for the dropdowns
        $provinces = Province::all();
        $prodi = ProgramStudi::all();

        return view('master.mahasiswa.edit', compact('mahasiswa', 'provinces', 'prodi'));
    }

    public function update(KtpRequest $request, Ktp $ktp)
    {
        // Menggunakan validated data dari KtpRequest
        $ktp->update($request->validated());

        // Redirect to the appropriate route with a success message
        return redirect()->route('mahasiswa.index')->with('success', 'KTP berhasil diubah');
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
