<?php

namespace App\Http\Controllers;

use App\Models\Hr;
use App\Models\Ktp;
use App\Models\Position;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class HrController extends Controller
{
    //crud
    public function index(Request $request)
    {
        // Menggunakan eager loading untuk relasi Ktp dan Position
        $hr = Hr::with(['ktp', 'position'])->paginate(100);
        return view('master.hr.index', compact('hr'));
    }
    
    

    public function create()
    {
        $provinces = Province::all();
        $positions = Position::all();
        $ktp = Ktp::all();
        return view('master.hr.create', compact('provinces', 'positions', 'ktp'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'nik' ,
            'nama',
            'alamat_jalan' ,
            'alamat_rt' ,
            'alamat_rw' ,
            'alamat_prov_code',
            'alamat_kotakab_code' ,
            'alamat_kec_code' ,
            'alamat_kel_code' ,
            'lahir_tempat',
            'lahir_tgl' ,
            'jenis_kelamin' ,
            'agama' ,
            'golongan_darah' ,
            'kewarganegaraan' ,
            'position_id' ,
            'nip' ,
            'gelar_depan' ,
            'nama',
            'gelar_belakang'
        ]);

        // Step 1: Create KTP Data
        $ktpData = $request->only([
            'nik',
            'nama',
            'alamat_jalan',
            'alamat_rt',
            'alamat_rw',
            'alamat_prov_code',
            'alamat_kotakab_code',
            'alamat_kec_code',
            'alamat_kel_code',
            'lahir_tempat',
            'lahir_tgl',
            'jenis_kelamin',
            'agama',
            'golongan_darah',
            'kewarganegaraan'
        ]);

        $ktp = Ktp::create($ktpData);

        // Step 2: Create HR Data with the created KTP ID
        $hrData = $request->only([
            'position_id',
            'nip',
            'gelar_depan',
            'nama',
            'gelar_belakang'
        ]);
        $hrData['ktp_id'] = $ktp->id;

        Hr::create($hrData);

        return redirect()->route('hr.index')->with('success', 'Biodata HR berhasil ditambahkan');
    }

    public function edit($id)
    {
        $hr = Hr::find($id);
        $positions = Position::all();
        $provinces = Province::all();
        $cities = City::where('province_code', $hr->ktp->alamat_prov_code)->get();
        $districts = District::where('city_code', $hr->ktp->alamat_kotakab_code)->get();
        $villages = Village::where('district_code', $hr->ktp->alamat_kec_code)->get();
        return view('master.hr.edit', compact('hr', 'positions', 'provinces', 'cities', 'districts', 'villages'));
    }

    //update data with fk position_id, ktp_id, hr data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' ,
            'nama',
            'alamat_jalan' ,
            'alamat_rt' ,
            'alamat_rw' ,
            'alamat_prov_code',
            'alamat_kotakab_code' ,
            'alamat_kec_code' ,
            'alamat_kel_code' ,
            'lahir_tempat',
            'lahir_tgl' ,
            'jenis_kelamin' ,
            'agama' ,
            'golongan_darah' ,
            'kewarganegaraan' ,
            'position_id' ,
            'nip' ,
            'gelar_depan' ,
            'nama',
            'gelar_belakang'
        ]);

        // Step 1: Update KTP Data
        $ktpData = $request->only([
            'nik',
            'nama',
            'alamat_jalan',
            'alamat_rt',
            'alamat_rw',
            'alamat_prov_code',
            'alamat_kotakab_code',
            'alamat_kec_code',
            'alamat_kel_code',
            'lahir_tempat',
            'lahir_tgl',
            'jenis_kelamin',
            'agama',
            'golongan_darah',
            'kewarganegaraan'
        ]);

        $hr = Hr::find($id);
        $hr->ktp->update($ktpData);

        // Step 2: Update HR Data
        $hrData = $request->only([
            'position_id',
            'nip',
            'gelar_depan',
            'nama',
            'gelar_belakang'
        ]);

        $hr->update($hrData);

        return redirect()->route('hr.index')->with('success', 'Biodata HR berhasil diperbarui');
    }


    public function destroy($id)
    {
        Hr::find($id)->delete();
        return redirect()->route('hr.index')->with('success', 'HR berhasil dihapus');
    }

    public function show($id)
{
    // Mengambil data HR beserta relasi Ktp dan Position menggunakan eager loading
    $hr = Hr::with(['ktp', 'position'])->findOrFail($id);

    // Mengambil data provinsi, kota/kabupaten, kecamatan, dan kelurahan/desa berdasarkan data dari Ktp
    $province = Province::where('code', $hr->ktp->alamat_prov_code)->first();
    $city = City::where('code', $hr->ktp->alamat_kotakab_code)->first();
    $district = District::where('code', $hr->ktp->alamat_kec_code)->first();
    $village = Village::where('code', $hr->ktp->alamat_kel_code)->first();
    // Mengirim data ke view
    return view('master.hr.show', compact('hr', 'province', 'city', 'district', 'village'));
}

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
