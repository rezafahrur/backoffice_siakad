<?php

namespace App\Http\Controllers;

use App\Models\Hr;
use App\Models\Config;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\RuangKelas;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\Kurikulum;
use App\Models\Kelas;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total mahasiswa
        $total_mahasiswa = Mahasiswa::count();

        // Menghitung total dosen (hr yang position-nya dosen)
        $total_dosen = Hr::whereHas('position', function ($query) {
            $query->where('posisi', 'dosen');
        })->count();

        // Menghitung total HR
        $total_hr = Hr::count();

        // get total ruang kelas
        $total_ruang_kelas = RuangKelas::count();

        // get program studi
        $total_prodi = ProgramStudi::count();

        // mata kuliah
        $total_mata_kuliah = MataKuliah::count();

        // kurikulum
        $total_kurikulum = Kurikulum::count();

        $kelas = Kelas::count();

        // get mahasiswa dengan status 1 dan 0
        $mahasiswa = Mahasiswa::where('status', 1)->orWhere('status', 0)->get();

        // Get the active semester code from the config table
        $config = Config::where('key', 'SEMESTER_AKTIF')->first();

        // Get the active semester name using the kode_semester from the config
        $semester_aktif = Semester::where('kode_semester', $config->value)->first();

        // get bulan dan tahun saat ini, dengan format seperti ini "Agustus 2021"
        $bulan_tahun = date('F Y');

        return view('dashboard', [
            'total_prodi' => $total_prodi,
            'total_ruang_kelas' => $total_ruang_kelas,
            'mahasiswa' => $mahasiswa,
            'total_mahasiswa' => $total_mahasiswa,
            'total_hr' => $total_hr,
            'total_dosen' => $total_dosen,
            'semester_aktif' => $semester_aktif,
            'bulan_tahun' => $bulan_tahun,
            'total_mata_kuliah' => $total_mata_kuliah,
            'total_kurikulum' => $total_kurikulum,
            'total_kelas' => $kelas,
        ]);
    }

    public function profile()
    {
        // Get the logged-in user's HR model
        $user = Hr::where('id', Session::get('hr_id'))->first();

        return view('master.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        try {
            // Get the logged-in user's HR model
            $user = Hr::where('id', Session::get('hr_id'))->first();

            // Validate the incoming request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:m_hr,email,' . $user->id,
                'phone' => 'required|string|max:15',
                'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Update the user's data
            $user->nama = $request->input('name');
            $user->email = $request->input('email');

            // Update phone number in HrDetail
            $user->hrDetail->hp = $request->input('phone');
            $user->hrDetail->save();

            // Handle photo profile upload
            if ($request->hasFile('photo_profile')) {
                $path = $request->file('photo_profile')->store('photo_profiles', 'public');
                $user->photo_profile = $path;
            }

            // Save the updated user data
            $user->save();

            //update session
            Session::put('photo_profile', $user->photo_profile);

            // Flash a success message to the session
            Session::flash('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            // Flash an error message to the session
            Session::flash('error', 'Profile update failed. Please try again.');
        }

        return redirect()->route('profile');
    }

    public function getMahasiswaStatus()
    {
        $mahasiswaAktif = Mahasiswa::where('status', 1)->count();
        $mahasiswaNonAktif = Mahasiswa::where('status', 0)->count();

        return response()->json([
            'aktif' => $mahasiswaAktif,
            'non_aktif' => $mahasiswaNonAktif,
        ]);
    }
}
