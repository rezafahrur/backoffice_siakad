<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Hr;
use App\Models\Ktp;
use App\Models\Position;
use App\Models\HrDetail;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Intervention\Image\Laravel\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
class HrController extends Controller
{
    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     $hr = Hr::with(['ktp', 'position', 'hrDetail']);
        //     return DataTables::of($hr)
        //         ->addIndexColumn()
        //         ->addColumn('nama', function ($row) {
        //             return $row->ktp->nama;
        //         })
        //         ->addColumn('posisi', function ($row) {
        //             return $row->position->posisi ?? 'No Position Assigned';
        //         })
        //         ->addColumn('photo_profile', function ($row) {
        //             // Mendapatkan path yang tepat
        //             $photoPath = storage_path('app/public/' . $row->photo_profile);

        //             // Menggunakan file_exists untuk memeriksa keberadaan file
        //             if ($row->photo_profile && file_exists($photoPath)) {
        //                 return '<img src="'.asset('storage/' . $row->photo_profile).'" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">';
        //             }

        //             // Default image jika foto tidak ditemukan
        //             return '<img src="'.asset('assets/images/faces/2.jpg').'" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">';
        //         })

        //         ->addColumn('action', function($row) {
        //             $editBtn = '<a href="' . route('hr.edit', $row->id) . '" class="btn icon btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
        //             $deleteBtn = '<form action="' . route('hr.destroy', $row->id) . '" method="post" class="d-inline">
        //                               ' . csrf_field() . method_field('DELETE') . '
        //                               <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-sm btn-danger" title="Delete">
        //                                   <i class="bi bi-trash"></i>
        //                               </button>
        //                           </form>';
        //             $showBtn = '<a href="' . route('hr.show', $row->id) . '" class="btn icon btn-sm btn-primary" title="Detail"><i class="bi bi-eye"></i></a>';
        //             return $showBtn . ' ' . $editBtn . ' ' . $deleteBtn;
        //         })
        //         ->rawColumns(['photo_profile', 'action']) // Ensures that HTML code for the action buttons is rendered correctly
        //         ->make(true);
        // }
        $hr = Hr::with(['ktp', 'position', 'hrDetail'])->get();

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
            'nik' => 'required',
            'nama' => 'required',
            'alamat_jalan' => 'required',
            'alamat_rt' => 'required',
            'alamat_rw' => 'required',
            'alamat_prov_code' => 'required',
            'alamat_kotakab_code' => 'required',
            'alamat_kec_code' => 'required',
            'alamat_kel_code' => 'required',
            'lahir_tempat' => 'required',
            'lahir_tgl' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'golongan_darah' => 'required',
            'kewarganegaraan' => 'required',
            'position_id' => 'required',
            'nip' => 'required',
            'gelar_depan' => 'nullable',
            'nama' => 'required',
            'gelar_belakang' => 'nullable',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hp' => 'required',
            'email' => 'required|email',
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
            'gelar_belakang',
            'email',
        ]);
        $hrData['ktp_id'] = $ktp->id;

        if ($request->hasFile('photo_profile')) {
            $path = $request->file('photo_profile')->store('photo_profiles', 'public');
            $hrData['photo_profile'] = $path;
        }

        $hr = Hr::create($hrData);

        // Step 3: Create HrDetail Data with the created HR ID
        $hrDetailData = $request->only([
            'hp',
        ]);
        $hrDetailData['master_hr_id'] = $hr->id;

        HrDetail::create($hrDetailData);

        return redirect()->route('hr.index')->with('success', 'Biodata SDM berhasil ditambahkan');
    }


    public function edit($id)
    {
        $hr = Hr::with('hrDetail')->find($id);
        $positions = Position::all();
        $provinces = Province::all();
        $cities = City::where('province_code', $hr->ktp->alamat_prov_code)->get();
        $districts = District::where('city_code', $hr->ktp->alamat_kotakab_code)->get();
        $villages = Village::where('district_code', $hr->ktp->alamat_kec_code)->get();
        return view('master.hr.edit', compact('hr', 'positions', 'provinces', 'cities', 'districts', 'villages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' ,
            'nama' ,
            'alamat_jalan' ,
            'alamat_rt' ,
            'alamat_rw' ,
            'alamat_prov_code' ,
            'alamat_kotakab_code' ,
            'alamat_kec_code' ,
            'alamat_kel_code' ,
            'lahir_tempat' ,
            'lahir_tgl' ,
            'jenis_kelamin' ,
            'agama',
            'golongan_darah' ,
            'kewarganegaraan' ,
            'position_id' ,
            'nip' ,
            'gelar_depan' ,
            'nama' ,
            'gelar_belakang',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hp',
            'email',
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
            'gelar_belakang',
            'email',
        ]);

        if ($request->hasFile('photo_profile')) {
            // Delete old photo if exists
            if ($hr->photo_profile) {
                Storage::disk('public')->delete($hr->photo_profile);
            }

            // Store new photo
            $path = $request->file('photo_profile')->store('photo_profiles', 'public');
            $hrData['photo_profile'] = $path;
        }

        $hr->update($hrData);

        // Step 3: Update HrDetail Data
        $hrDetailData = $request->only([
            'hp',
        ]);

        $hr->hrDetail->update($hrDetailData);

        return redirect()->route('hr.index')->with('success', 'Biodata SDM berhasil diperbarui');
    }

    public function destroy($id)
    {
        $hr = Hr::find($id);
        $hr->hrDetail()->delete();
        $hr->delete();

        return redirect()->route('hr.index')->with('success', 'SDM berhasil dihapus');
    }

    public function show($id)
    {
        $hr = Hr::with(['ktp', 'position', 'hrDetail'])->findOrFail($id);

        $province = Province::where('code', $hr->ktp->alamat_prov_code)->first();
        $city = City::where('code', $hr->ktp->alamat_kotakab_code)->first();
        $district = District::where('code', $hr->ktp->alamat_kec_code)->first();
        $village = Village::where('code', $hr->ktp->alamat_kel_code)->first();

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
