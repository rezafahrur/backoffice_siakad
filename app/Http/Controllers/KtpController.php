<?php

namespace App\Http\Controllers;

use App\Http\Requests\KtpRequest;
use App\Models\Ktp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class KtpController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $ktp = Ktp::when($search, function ($query, $search) {
            $query->where('nik', 'like', "%$search%")
                ->orWhere('nama_lengkap', 'like', "%$search%");
        })
            ->paginate(10);

        return view('master.ktp.index', compact('ktp'));
    }

    public function create()
    {
        // Fetch data for the dropdowns
        $provinces = Province::all();
        return view('master.ktp.create', compact('provinces'));
    }

    public function store(KtpRequest $request)
    {

        $validateData = $request->validated();

        // Create a new KTP record
        KTP::create($validateData);

        // Redirect to the appropriate route with a success message
        return redirect()->route('ktp.index')->with('success', 'KTP berhasil ditambahkan');
    }

    public function show(Ktp $ktp)
    {
        // Mengambil data KTP dari database
        $ktp = KTP::findOrFail($ktp->id);

        // Mendapatkan data provinsi, kota/kabupaten, kecamatan, dan kelurahan/desa
        $province = Province::where('code', $ktp->alamat_prov_code)->first();
        $city = City::where('code', $ktp->alamat_kotakab_code)->first();
        $district = District::where('code', $ktp->alamat_kec_code)->first();
        $village = Village::where('code', $ktp->alamat_kel_code)->first();

        // Mengirim data ke view
        return view('master.ktp.detail', [
            'ktp' => $ktp,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'village' => $village,
        ]);
    }

    public function edit(Ktp $ktp)
    {
        // Fetch data for the dropdowns and populate with existing ktp data
        $provinces = Province::all();
        $cities = City::where('province_code', $ktp->alamat_provinsi_id)->get();
        $districts = District::where('city_code', $ktp->alamat_kotakab_id)->get();
        $villages = Village::where('district_code', $ktp->alamat_kecamatan_id)->get();

        return view('master.ktp.edit', compact('ktp', 'provinces', 'cities', 'districts', 'villages'));
    }

    public function update(KtpRequest $request, Ktp $ktp)
    {
        // Menggunakan validated data dari KtpRequest
        $ktp->update($request->validated());

        // Redirect to the appropriate route with a success message
        return redirect()->route('ktp.index')->with('success', 'KTP berhasil diubah');
    }

    public function destroy(Ktp $ktp)
    {
        $ktp->delete();

        return redirect()->route('ktp.index')->with('success', 'KTP berhasil dihapus');
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
